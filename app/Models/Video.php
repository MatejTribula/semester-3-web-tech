<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Image;
use App\Models\Video;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'images' => 'array',
            'images.*' => 'nullable|string',
            'videos' => 'array',
            'videos.*' => 'nullable|string',
            'tags' => 'array',
            'tags.*' => 'nullable|string',
            'collaborators' => 'array',
            'collaborators.*' => 'nullable|integer',
        ]);

        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        if (! empty($validated['images'])) {
            foreach ($validated['images'] as $url) {
                if (!$url) continue;
                $image = new Image;
                $image->product_id = $product->id;
                $image->image_url = $url;
                $image->save();
            }
        }

        if (! empty($validated['videos'])) {
            foreach ($validated['videos'] as $url) {
                if (!$url) continue;
                $video = new Video;
                $video->product_id = $product->id;
                $video->video_url = $url;
                $video->save();
            }
        }

        if (! empty($validated['tags'])) {
            foreach ($validated['tags'] as $tagName) {
                if (!$tagName) continue;
                $tag = new Tag;
                $tag->product_id = $product->id;
                $tag->tag_value = $tagName;
                $tag->save();
            }
        }

        if (! empty($validated['collaborators'])) {
            foreach ($validated['collaborators'] as $userId) {
                if (!$userId) continue;
                DB::table('product_collaborators')->insert([
                    'product_id' => $product->id,
                    'user_id' => $userId,
                ]);
            }
        }

        return redirect()->route('products.show', $product);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'images' => 'array',
            'images.*' => 'nullable|string',
            'videos' => 'array',
            'videos.*' => 'nullable|string',
            'tags' => 'array',
            'tags.*' => 'nullable|string',
            'collaborators' => 'array',
            'collaborators.*' => 'nullable|integer',
        ]);

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        if (! empty($validated['images'])) {
            Image::where('product_id', $product->id)->delete();
            foreach ($validated['images'] as $url) {
                if (!$url) continue;
                Image::create([
                    'product_id' => $product->id,
                    'image_url' => $url,
                ]);
            }
        }

        if (! empty($validated['videos'])) {
            Video::where('product_id', $product->id)->delete();
            foreach ($validated['videos'] as $url) {
                if (!$url) continue;
                Video::create([
                    'product_id' => $product->id,
                    'video_url' => $url,
                ]);
            }
        }

        if (! empty($validated['tags'])) {
            Tag::where('product_id', $product->id)->delete();
            foreach ($validated['tags'] as $tagName) {
                if (!$tagName) continue;
                Tag::create([
                    'product_id' => $product->id,
                    'tag_value' => $tagName,
                ]);
            }
        }

        if (! empty($validated['collaborators'])) {
            DB::table('product_collaborators')->where('product_id', $product->id)->delete();
            foreach ($validated['collaborators'] as $userId) {
                if (!$userId) continue;
                DB::table('product_collaborators')->insert([
                    'product_id' => $product->id,
                    'user_id' => $userId,
                ]);
            }
        }

        return redirect()->route('products.show', $product);
    }
}