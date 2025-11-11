<?php

namespace App\Http\Controllers;

use App\Models\Product;

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

    // public function create()
    // {
    //     return view('publish-new-game');
    // }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'upload_date' => 'nullable|date',
    //         'approval_date' => 'nullable|date',
    //         'visibility_setting' => 'required|string|max:50',
    //         'file_url' => 'nullable|url',

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
