<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use App\Models\Tag;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

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
        
        // collects tags from the loaded products, and gives them a unique tag value. flatMap method maps all arrays and creates new flat array.
        $tags = $products
            ->flatMap(fn ($product) => $product->tags) 
            ->unique('tag_value')
            ->values();

        return view('products.index', compact('products','tags'));
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

    /// JSON response stayed because if we get an error here, something is very wrong.
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
            'file_url' => 'nullable|url',
            'wasm_file_name' => 'nullable|string|max:64',
            'wasm_width' => 'nullable|integer',
            'wasm_height' => 'nullable|integer',

            'cover_url' => 'required|url',

            'images' => 'nullable|array',
            'images.*' => 'nullable|url',
            'videos' => 'nullable|array',
            'videos.*' => 'nullable|url',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string|max:32',
            'collaborators' => 'nullable|array',
            'collaborators.*' => 'nullable|integer|exists:users,id',
            'wasm_zip' => 'nullable|file|mimes:zip|max:51200', // 50MB

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
            $product->wasm_file_name = $validated['wasm_file_name'] ?? null;
            $product->wasm_width = $validated['wasm_width'] ?? null;
            $product->wasm_height = $validated['wasm_height'] ?? null;
            $product->save();

            // Unpack WASM ZIP (if provided) and set wasm_file_name
            if ($request->hasFile('wasm_zip')) 
            {
                $this->unpackWasmZip($product, $request->file('wasm_zip'));
            }

            \Log::info('Product saved ID: '.$product->id);

            Image::create([
                'product_id' => $product->id,
                'image_url' => $validated['file_url'],
            ]);

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
            return redirect()->route('show', ['id' => $product->id]);
            

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

    /// JSON response stayed because if we get an error here, something is very wrong.
    public function update(Request $request, $id)
    {
        if (! $this->isAuthorizedToEditProduct($id)) {
            abort(403, 'Unauthorized access to this product');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:64',
            'description' => 'nullable|string',
            'upload_date' => 'nullable|date',
            'approval_date' => 'nullable|date',
            'visibility_setting' => 'required|in:Public,Unlisted,Private',
            'file_url' => 'nullable|url',
            'wasm_file_name' => 'nullable|string|max:64',
            'wasm_width' => 'nullable|integer',
            'wasm_height' => 'nullable|integer',

            'images' => 'nullable|array',
            'images.*' => 'nullable|url',
            'videos' => 'nullable|array',
            'videos.*' => 'nullable|url',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string|max:32',
            'collaborators' => 'nullable|array',
            'collaborators.*' => 'nullable|integer|exists:users,id',
            'wasm_zip' => 'nullable|file|mimes:zip|max:51200', // 50MB

        ]);

        DB::beginTransaction();
        try {
            // 1. Find product
            $product = Product::findOrFail($id);


            // tracking for the old title, for the folder names
            $oldTitle = $product->getOriginal('title');


            // 2. Update base fields
            $product->title = $validated['title'];
            $product->description = $validated['description'] ?? null;
            $product->upload_date = $validated['upload_date'] ?? null;
            $product->approval_date = $validated['approval_date'] ?? null;
            $product->visibility_setting = $validated['visibility_setting'];
            $product->file_url = $validated['file_url'] ?? null;
            $product->wasm_file_name = $validated['wasm_file_name'] ?? null;
            $product->wasm_width = $validated['wasm_width'] ?? null;
            $product->wasm_height = $validated['wasm_height'] ?? null;
            $product->save();

            if ($oldTitle && $oldTitle !== $product->title) 
            {
                $disk = Storage::disk('public');
                $oldRel = 'wasm/'.$oldTitle;
                $newRel = 'wasm/'.$product->title;
                $oldPath = $disk->path($oldRel);
                $newPath = $disk->path($newRel);

                if (is_dir($oldPath)) 
                {
                    // ensure parent exists; don’t pre-create destination dir
                    $disk->makeDirectory('wasm');
                    @rename($oldPath, $newPath);
                    // clean any empty old dir
                    $disk->deleteDirectory($oldRel);
                }
            }

            // Unpack WASM ZIP (if provided) and set wasm_file_name
            if ($request->hasFile('wasm_zip')) 
            {
                $this->unpackWasmZip($product, $request->file('wasm_zip'));
            }

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

            return redirect()->route('show', ['id' => $product->id]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if (! $this->isAuthorizedToEditProduct($product)) 
        {
            abort(403, 'Unauthorized access to this product');
        }

        // remove extracted WASM bundle
        $disk = Storage::disk('public');
        $rel = 'wasm/'.$product->title;
        // delete directory unconditionally
        $disk->deleteDirectory($rel);

        // Detach pivot table relations
        $product->favorites()->detach();
        $product->collaborators()->detach();

        // Delete the product (tags, images, videos will cascade automatically)
        $product->delete();

        return redirect()->route('my-uploads');
    }

    /**
     * Unpack the uploaded ZIP into public/storage/wasm/{title}/
     * and set $product->wasm_file_name to the detected HTML entry (basename).
     */
    private function unpackWasmZip(Product $product, \Illuminate\Http\UploadedFile $zip)
    {
        // store ZIP temporarily on local (private) disk
        $tmp = Storage::disk('local')->putFile('tmp', $zip); // storage/app/private/tmp/xxx.zip
        $zipPath = Storage::disk('local')->path($tmp);

        // destination under public disk
        $destRel = 'wasm/'.$product->title;
        $destPath = Storage::disk('public')->path($destRel);

        // clean and recreate destination
        Storage::disk('public')->deleteDirectory($destRel);
        Storage::disk('public')->makeDirectory($destRel);

        // extract
        $za = new ZipArchive();
        if ($za->open($zipPath) !== true) 
        {
            throw new \RuntimeException('Failed to open WASM ZIP');
        }
        $za->extractTo($destPath);
        $za->close();

        // find HTML entry (prefer index.html)
        $entry = $this->findHtmlEntry($destPath);
        if ($entry) 
        {
            $product->wasm_file_name = pathinfo($entry, PATHINFO_FILENAME); // basename without .html
            $product->save();
        }

        // cleanup temp
        @unlink($zipPath);
    }

    /**
     * Find an HTML file in extracted bundle; prefer index.html.
     */
    private function findHtmlEntry(string $root)
    {
        $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($root, \FilesystemIterator::SKIP_DOTS));
        $first = null;
        foreach ($rii as $file) 
        {
            if ($file->isFile() && strtolower($file->getExtension()) === 'html') 
            {
                $path = $file->getPathname();
                if (!$first) $first = $path;
                if (strtolower($file->getFilename()) === 'index.html') 
                {
                    return $path;
                }
            }
        }
        return $first;
    }

}
