<?php

namespace App\Http\Controllers;

use App\Models\Product;


class UserController extends Controller 
{
    // this is userController related task
    public function productsByCollaborator($id = null)
    {
        $id = $id ?? auth()->id();

        if (!$id) 
        {
            abort(403, 'Not authenticated');
        }

        $products = Product::with(['images', 'videos', 'tags', 'collaborators', 'favorites'])
            ->whereHas('collaborators', function ($q) use ($id) {
                $q->where('user_id', (int) $id);
            })->get();

        return view('my-uploads', compact('products'));
    }

}
