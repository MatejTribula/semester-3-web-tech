<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use App\Models\Tag;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['images', 'videos', 'tags', 'collaborators', 'favorites'])->get();

        // return view('index', compact('products'));
        return response()->json($products, 200); // json for now
    }

    // public function show($id)
    // {
    //     $game = Game::findOrFail($id);

    //     return view('product', compact('game'));
    // }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:64',
            'description' => 'nullable|string',
            'upload_date' => 'nullable|date',
            'approval_date' => 'nullable|date',
            'visibility_setting' => 'required|in:Public,Unlisted,Private',
            'file_url' => 'nullable|url',

            'images' => 'nullable|array',
            'images.*' => 'required|url',
            'videos' => 'nullable|array',
            'videos.*' => 'required|url',
            'tags' => 'nullable|array',
            'tags.*' => 'required|string|max:32',
            'collaborators' => 'nullable|array',
            'collaborators.*' => 'required|integer|exists:users,id',
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

            // 2. Create related images (explicitly set product_id)
            if (! empty($validated['images'])) {
                foreach ($validated['images'] as $url) {
                    $image = new Image;
                    $image->product_id = $product->id;
                    $image->images_url = $url;
                    $image->save();
                }
            }

            // 3. Create related videos
            if (! empty($validated['videos'])) {
                foreach ($validated['videos'] as $url) {
                    $video = new Video;
                    $video->product_id = $product->id;
                    $video->video_url = $url; // make sure Video has video_url field
                    $video->save();
                }
            }

            // 4. Create related tags
            if (! empty($validated['tags'])) {
                foreach ($validated['tags'] as $tagName) {
                    $tag = new Tag;
                    $tag->product_id = $product->id;
                    $tag->tag_value = $tagName; // make sure Tag has name field
                    $tag->save();
                }
            }
            if (! empty($validated['collaborators'])) {
                foreach ($validated['collaborators'] as $userId) {
                    DB::table('product_collaborators')->insert([
                        'product_id' => $product->id,
                        'user_id' => $userId,
                    ]);
                }
            }

            DB::commit();

            // 6. Return response
            return response()->json([
                'message' => 'Product created successfully!',
                'product' => $product,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'upload_date' => 'nullable|date',
    //         'approval_date' => 'nullable|date',
    //         'visibility_setting' => 'required|string|max:50',
    //         'file_url' => 'required|url',

    //         // related data
    //         'images' => 'array',
    //         'images.*.path' => 'required|string',

    //         'videos' => 'array',
    //         'videos.*.url' => 'required|url',

    //         'tags' => 'array',
    //         'tags.*.name' => 'required|string|max:100',

    //         'collaborators' => 'array',
    //         'collaborators.*' => 'integer|exists:users,id',
    //     ]);

    //     DB::transaction(function () use ($validated) {
    //         // 1️⃣ Create product
    //         $product = Product::create([
    //             'title' => $validated['title'],
    //             'description' => $validated['description'] ?? null,
    //             'upload_date' => $validated['upload_date'] ?? now(),
    //             'approval_date' => $validated['approval_date'] ?? null,
    //             'visibility_setting' => $validated['visibility_setting'],
    //             'file_url' => $validated['file_url'] ?? null,
    //         ]);

    //         // 2️⃣ Create images
    //         if (! empty($validated['images'])) {
    //             foreach ($validated['images'] as $imageData) {
    //                 $product->images()->create([
    //                     'path' => $imageData['path'],
    //                 ]);
    //             }
    //         }

    //         // 3️⃣ Create videos
    //         if (! empty($validated['videos'])) {
    //             foreach ($validated['videos'] as $videoData) {
    //                 $product->videos()->create([
    //                     'url' => $videoData['url'],
    //                 ]);
    //             }
    //         }

    //         // 4️⃣ Create tags
    //         if (! empty($validated['tags'])) {
    //             foreach ($validated['tags'] as $tagData) {
    //                 $product->tags()->create([
    //                     'name' => $tagData['name'],
    //                 ]);
    //             }
    //         }

    //         // 5️⃣ Attach collaborators
    //         if (! empty($validated['collaborators'])) {
    //             $product->collaborators()->attach($validated['collaborators']);
    //         }
    //     });

    //     return response()->json(['message' => 'Product and related data created successfully'], 201);
    // }

    // public function edit($id)
    // {
    //     $product = Product::with(['images', 'videos', 'tags', 'collaborators'])->findOrFail($id);

    //     return view('products.edit', compact('product'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $validated = $request->validate([
    //         'title' => 'sometimes|required|string|max:255',
    //         'description' => 'nullable|string',
    //         'upload_date' => 'nullable|date',
    //         'approval_date' => 'nullable|date',
    //         'visibility_setting' => 'sometimes|required|string|max:50',
    //         'file_url' => 'nullable|url',

    //         'images' => 'array',
    //         'images.*.id' => 'nullable|integer|exists:images,id',
    //         'images.*.path' => 'required|string',

    //         'videos' => 'array',
    //         'videos.*.id' => 'nullable|integer|exists:videos,id',
    //         'videos.*.url' => 'required|url',

    //         'tags' => 'array',
    //         'tags.*.id' => 'nullable|integer|exists:tags,id',
    //         'tags.*.name' => 'required|string|max:100',

    //         'collaborators' => 'array',
    //         'collaborators.*' => 'integer|exists:users,id',
    //     ]);

    //     DB::transaction(function () use ($validated, $id) {
    //         $product = Product::findOrFail($id);

    //         // 1️⃣ Update product
    //         $product->update([
    //             'title' => $validated['title'] ?? $product->title,
    //             'description' => $validated['description'] ?? $product->description,
    //             'upload_date' => $validated['upload_date'] ?? $product->upload_date,
    //             'approval_date' => $validated['approval_date'] ?? $product->approval_date,
    //             'visibility_setting' => $validated['visibility_setting'] ?? $product->visibility_setting,
    //             'file_url' => $validated['file_url'] ?? $product->file_url,
    //         ]);

    //         // 2️⃣ Sync images
    //         if (isset($validated['images'])) {
    //             $product->images()->delete(); // remove old
    //             foreach ($validated['images'] as $imageData) {
    //                 $product->images()->create([
    //                     'path' => $imageData['path'],
    //                 ]);
    //             }
    //         }

    //         // 3️⃣ Sync videos
    //         if (isset($validated['videos'])) {
    //             $product->videos()->delete();
    //             foreach ($validated['videos'] as $videoData) {
    //                 $product->videos()->create([
    //                     'url' => $videoData['url'],
    //                 ]);
    //             }
    //         }

    //         // 4️⃣ Sync tags
    //         if (isset($validated['tags'])) {
    //             $product->tags()->delete();
    //             foreach ($validated['tags'] as $tagData) {
    //                 $product->tags()->create([
    //                     'name' => $tagData['name'],
    //                 ]);
    //             }
    //         }

    //         // 5️⃣ Sync collaborators (many-to-many)
    //         if (isset($validated['collaborators'])) {
    //             $product->collaborators()->sync($validated['collaborators']);
    //         }
    //     });

    //     return response()->json(['message' => 'Product and related data updated successfully'], 200);
    // }

    // public function destroy($id)
    // {
    //     DB::transaction(function () use ($id) {
    //         $product = Product::with(['images', 'videos', 'tags', 'collaborators'])->findOrFail($id);

    //         // 1️⃣ Delete related models
    //         $product->images()->delete();
    //         $product->videos()->delete();
    //         $product->tags()->delete();

    //         // 2️⃣ Detach many-to-many relationships
    //         $product->collaborators()->detach();
    //         $product->favorites()->detach();

    //         // 3️⃣ Finally, delete the product
    //         $product->delete();
    //     });

    //     return response()->json(['message' => 'Product and related data deleted successfully'], 200);
    // }
}
