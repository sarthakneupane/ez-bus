<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
     public function index()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
        'password' => 'nullable|string|min:6|confirmed',
    ]);

    $user->name = $request->name;
    $user->phone = $request->phone;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->back()->with('success', 'Profile updated successfully.');
}

}
