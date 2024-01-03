<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Notifications\UserCreateNotification;

class UserController extends Controller
{
    public function index() {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function create() {
        $users = User::all();
        return view('admin.users.create', compact('users'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'max:20'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
        ]);

        $user->notify(new UserCreateNotification($user));

        return redirect()->route('users')->with('success', 'User created successfully.!');
    }

    public function edit($id){
        $users = User::where('id',$id)->first();
        return view('admin.users.edit', compact('users'));
    }
    public function update(Request $request)
    {

        $user = User::find($request->id);

        if ($user) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->password = Hash::make($request->password);

            $user->save();

        }
            return redirect()->route('users')->with('success', 'User Updated successfully.!');
    }

    public function delete($id){
        $users = User::where('id',$id)->delete();
        return redirect()->route('users')->with('error', 'User delete successfully.!');
    }
}
