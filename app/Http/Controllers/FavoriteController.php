<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function getFavoriteProducts($id = null)
    {
        $id = $id ?? auth()->id();

        if (!$id) 
        {
            abort(403, 'Not authenticated');
        }

        $products = Product::with(['images', 'videos', 'tags', 'collaborators', 'favorites'])
            ->whereHas('favorites', function ($q) use ($id) {
                $q->where('user_id', (int) $id);
            })->get();

        return view('favorites', compact('products'));
    }

    public function addFavorite(Request $request, $id)
    {
        $user = $request->user();
        
        if (!$user) 
        {
            return response()->json(['error' => 'Not authenticated'], 401);
        }

        $product = Product::find($id);
        if (!$product) 
        {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $user->favoriteProducts()->syncWithoutDetaching([
            $id => ['starred_date' => now()]
        ]);

        return response()->json(['message' => 'Product added to favorites'], 200);
    }

    public function removeFavorite(Request $request, $id)
    {
        $user = $request->user();

        if (!$user) 
        {
            return response()->json(['error' => 'Not authenticated'], 401);
        }

        $product = Product::find($id);
        if (!$product) 
        {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $removed = $user->favoriteProducts()->detach($id);

        if ($removed) 
        {
            return response()->json(['message' => 'Product removed from favorites'], 200);
        }

        return response()->json(['error' => 'Product was not in favorites'], 404);

    }
}
