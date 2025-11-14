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
}
