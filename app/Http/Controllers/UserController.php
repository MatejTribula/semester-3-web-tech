<?php

namespace App\Http\Controllers;

use App\Models\Product;


class UserController extends Controller 
{
    // this is userController related task
    public function productsByCollaborator()
    {
        $id = auth()->id();
        
        if (!$id) 
        {
            abort(403, 'Not authenticated');
        }

        // Only products where the user is a collaborator
        $products = Product::with(['images', 'videos', 'tags', 'collaborators', 'favorites'])
            ->whereHas('collaborators', function ($q) use ($id) 
            {
                $q->where('users.id', $id);
            })->get();
        
        return view('my-uploads', compact('products'));
    }

}
