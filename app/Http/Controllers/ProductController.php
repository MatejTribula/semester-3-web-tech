<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use App\Models\Tag;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    private function isAuthorizedToSeeProduct($productOrId)
    {
        // accept either a Product instance or an id
        $product = $productOrId instanceof Product
            ? $productOrId
            : Product::with(['images', 'videos', 'tags', 'collaborators', 'favorites'])->find($productOrId);

        if (! $product) {
            return false;
        }

        // public or unlisted are accessible to everyone
        if (in_array($product->visibility_setting, ['Public', 'Unlisted'])) {
            return true;
        }

        // otherwise require authenticated collaborator
        $user = auth()->user();
        if (! $user) {
            return false;
        }

        return $product->collaborators->contains('id', $user->id);
    }

    private function isAuthorizedToEditProduct($productOrId)
    {
        // accept either a Product instance or an id
        $product = $productOrId instanceof Product
            ? $productOrId
            : Product::with(['images', 'videos', 'tags', 'collaborators', 'favorites'])->find($productOrId);

        if (! $product) {
            return false;
        }

        // otherwise require authenticated collaborator
        $user = auth()->user();
        if (! $user) {
            return false;
        }

        return $product->collaborators->contains('id', $user->id);
    }

    public function index()
    {
        $products = Product::with(['images', 'videos', 'tags', 'collaborators', 'favorites'])->whereIn('visibility_setting', ['Public'])->get();

        return view('products.index', compact('products'));
        // return response()->json($products, 200); // json for now
    }

    public function show($id)
    {
        $product = Product::with([
            'images',
            'videos',
            'tags',
            'collaborators',
            'favorites',
        ])->findOrFail($id); // automatically throws 404 if not found

        if (! $this->isAuthorizedToSeeProduct($product)) {
            abort(403, 'Unauthorized access to this product');
        }

        // Return a view called 'show' and pass the product data
        return view('products.show', compact('product'));
    }

    public function create()
    {
        $user = Auth::user();

        return view('products.create', ['user' => $user]);
    }

    public function store(Request $request)
    {

        $user = Auth::user();
        $validated = $request->validate([
            'title' => 'required|string|max:64',
            'logo' => 'nullable|url',
            'description' => 'nullable|string',
            'upload_date' => 'nullable|date',
            'approval_date' => 'nullable|date',
            'visibility_setting' => 'required|in:Public,Unlisted,Private',
            'file_url' => 'required|url',

            'images' => 'nullable|array',
            'images.*' => 'nullable|url',
            'videos' => 'nullable|array',
            'videos.*' => 'nullable|url',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string|max:32',
            'collaborators' => 'nullable|array',
            'collaborators.*' => 'nullable|integer|exists:users,id',
        ]);

        DB::beginTransaction();
        try {
            // 1. Create the product
            $product = new Product;
            $product->title = $validated['title'];
            $product->description = $validated['description'] ?? null;
            $product->upload_date = $validated['upload_date'] ?? null;
            $product->approval_date = $validated['approval_date'] ?? null;
            $product->visibility_setting = $validated['visibility_setting'];
            $product->file_url = $validated['file_url'] ?? null;
            $product->save();

            \Log::info('Product saved ID: '.$product->id);

            // 3. Create related images (explicitly set product_id)
            if (! empty($validated['images'])) {
                foreach ($validated['images'] as $url) {
                    if (! $url) {
                        continue;
                    }
                    $image = new Image;
                    $image->product_id = $product->id;
                    $image->image_url = $url;
                    $image->save();
                }
            }

            // 4. Create related videos
            if (! empty($validated['videos'])) {
                foreach ($validated['videos'] as $url) {
                    if (! $url) {
                        continue;
                    }
                    $video = new Video;
                    $video->product_id = $product->id;
                    $video->video_url = $url; // make sure Video has video_url field
                    $video->save();
                }
            }

            // 5. Create related tags
            if (! empty($validated['tags'])) {
                foreach ($validated['tags'] as $tagName) {
                    if (! $tagName) {
                        continue;
                    }
                    $tag = new Tag;
                    $tag->product_id = $product->id;
                    $tag->tag_value = $tagName; // make sure Tag has name field
                    $tag->save();
                }
            }

            DB::table('product_collaborators')->insert([
                'product_id' => $product->id,
                'user_id' => $user->id,
            ]);

            // 6. Create related collaborators
            if (! empty($validated['collaborators'])) {
                foreach ($validated['collaborators'] as $userId) {
                    if (! $userId) {
                        continue;
                    }
                    DB::table('product_collaborators')->insert([
                        'product_id' => $product->id,
                        'user_id' => $userId,
                    ]);
                }
            }

            DB::commit();

            // 7. Return response
            return response()->json([
                'message' => 'Product created successfully!',
                'product' => $product,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $user = auth()->user();
        $product = Product::with(['images', 'videos', 'tags', 'collaborators'])->findOrFail($id);

        if (! $this->isAuthorizedToEditProduct($product)) {
            abort(403, 'Unauthorized access to this product');
        }

        return view('products.edit', [
            'product' => $product,
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        if (! $this->isAuthorizedToEditProduct($id)) {
            return response()->json(['error' => 'Unauthorized access to this product'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:64',
            'description' => 'nullable|string',
            'upload_date' => 'nullable|date',
            'approval_date' => 'nullable|date',
            'visibility_setting' => 'required|in:Public,Unlisted,Private',
            'file_url' => 'nullable|url',

            'images' => 'nullable|array',
            'images.*' => 'nullable|url',
            'videos' => 'nullable|array',
            'videos.*' => 'nullable|url',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string|max:32',
            'collaborators' => 'nullable|array',
            'collaborators.*' => 'nullable|integer|exists:users,id',
        ]);

        DB::beginTransaction();
        try {
            // 1. Find product
            $product = Product::findOrFail($id);

            // 2. Update base fields
            $product->title = $validated['title'];
            $product->description = $validated['description'] ?? null;
            $product->upload_date = $validated['upload_date'] ?? null;
            $product->approval_date = $validated['approval_date'] ?? null;
            $product->visibility_setting = $validated['visibility_setting'];
            $product->file_url = $validated['file_url'] ?? null;
            $product->save();

            \Log::info('Product updated ID: '.$product->id);

            // 3. Sync images
            if (isset($validated['images'])) {
                Image::where('product_id', $product->id)->delete();
                foreach ($validated['images'] as $url) {
                    if ($url) {
                        Image::create([
                            'product_id' => $product->id,
                            'image_url' => $url,
                        ]);
                    }
                }
            }

            // 4. Sync videos
            if (isset($validated['videos'])) {
                Video::where('product_id', $product->id)->delete();
                foreach ($validated['videos'] as $url) {
                    if ($url) {
                        Video::create([
                            'product_id' => $product->id,
                            'video_url' => $url,
                        ]);
                    }
                }
            }

            // 5. Sync tags
            if (isset($validated['tags'])) {
                Tag::where('product_id', $product->id)->delete();
                foreach ($validated['tags'] as $tagName) {
                    if ($tagName) {
                        Tag::create([
                            'product_id' => $product->id,
                            'tag_value' => $tagName,
                        ]);
                    }
                }
            }

            // 6. Sync collaborators
            if (isset($validated['collaborators'])) {
                DB::table('product_collaborators')
                    ->where('product_id', $product->id)
                    ->delete();

                foreach ($validated['collaborators'] as $userId) {
                    if ($userId) {
                        DB::table('product_collaborators')->insert([
                            'product_id' => $product->id,
                            'user_id' => $userId,
                        ]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Product updated successfully!',
                'product' => $product,
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if (! $this->isAuthorizedToEditProduct($product)) {
            return response()->json(['error' => 'Unauthorized access to this product'], 403);
        }

        // Detach pivot table relations
        $product->favorites()->detach();
        $product->collaborators()->detach();

        // Delete the product (tags, images, videos will cascade automatically)
        $product->delete();

        return response()->json([
            'message' => 'Product and all related data deleted successfully.',
        ]);
    }
}
