<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;


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
    
    public function updateProfile(Request $request, $userId)
    {
        // Only allow users to edit their own profile
        if ((int) $userId !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'nickname' => 'required|string|max:100',
            'avatar' => 'nullable|image|max:2048', // 2MB max
        ]);

        $user = User::findOrFail($userId);
        $user->nickname = $validated['nickname'];

        // Handle avatar upload — store relative path on the "public" disk
        if ($request->hasFile('avatar')) {
            // delete old file (raw DB value) if present
            if ($user->getRawOriginal('avatar_url')) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->getRawOriginal('avatar_url'));
            }

            // store returns e.g. "avatars/abc123.jpg"
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar_url = $path; // save relative path only
        }

        $user->save();
        $user->refresh(); // ensure accessors return fresh data

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user
        ]);
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
