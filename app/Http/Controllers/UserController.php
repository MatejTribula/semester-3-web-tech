<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;


class UserController extends Controller 
{
    // this is userController related task
    public function productsByCollaborator($id = null)
    {
        $id = $id ?? auth()->id();

        if (! $id) 
        {
            abort(403, 'Not authenticated');
        }

        $products = Product::with(['images', 'videos', 'tags', 'collaborators', 'favorites'])
            ->whereHas('collaborators', function ($q) use ($id) {
                $q->where('user_id', (int) $id);
            })->get();

        return view('my-uploads', compact('products'));
    }

    //public user page

    public function showUserPage($userId = null){
        // If no userId provided, show authenticated user's profile
        $userId = $userId ?? auth()->id();
        
        if (!$userId) {
            return redirect()->route('login');
        }
        
        $user = User::with('collaborations')->findOrFail($userId);
        
        return view('profile', compact('user'));
    }
    //display their profile picture (alr in model)
    //display their name (alr in model)
    //display their bio
    //display all their created and contributed games


    //edit your own profile
    /*
    public function editProfile($userId = null){
        $userId = $userId ?? auth()->userId();

        if (! $id) 
        {
            abort(403, 'Not authenticated');
        }
    }*/
    //edit profile picture

    //edit bio

    //click "done", update authenticated user profile at the end of editing

}
