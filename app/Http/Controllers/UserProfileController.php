<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UserProfileController extends Controller
{
    public function index() {
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }

    public function edit($id) {
        $user = User::find($id);
        return view('admin.profile.edit', compact('user'));
    }

    public function update(Request $request, $id) {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;
        $user->profile_title_name = $request->profile_title_name;

        // if ($user->image && $request->image) {
        //     $imagePath = public_path('uploads/' . $user->image);
    
        //     // Check if the file exists before attempting to delete
        //     if (File::exists($imagePath)) {
        //         File::delete($imagePath);
        //     }
        // }

        // if ($request->image) {
        //     $image = $request->image;;
        //     $imageName = time() . '.' . $image->getClientOriginalExtension();
        //     $image->move(public_path('uploads'), $imageName);
        //     $user->image = $imageName;
        // }


        if ($user->profile_image && $request->profile_image) {
            $imagePath = public_path('template/images/profile-images/' . $user->profile_image);
    
            // Check if the file exists before attempting to delete
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        if ($request->profile_image) {
            $image = $request->profile_image;;
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('template/images/profile-images'), $imageName);
            $user->profile_image = $imageName;
        }
        // $user->profile_image = $request->profile_image;
        $user->save();
        return redirect()->route('user.profile')->with('success', 'Profile updated successfully.');
    }
}
