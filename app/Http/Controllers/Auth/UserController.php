<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function me(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'name' => ['sometimes','string','max:255'],
            'email' => ['sometimes','email','max:255','unique:users,email,'.$user->id],
        ]);
        $user->fill($data);
        $user->save();
        return response()->json([
            'message' => 'Profile updated',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);
    }

    public function changePassword(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'current_password' => ['required','string'],
            'password' => ['required','string','min:8','confirmed'],
        ]);
        if (!Hash::check($data['current_password'], $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 422);
        }
        $user->password = Hash::make($data['password']);
        $user->save();
        return response()->json(['message' => 'Password changed successfully']);
    }

    public function uploadAvatar(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'avatar' => ['required','image','mimes:jpg,jpeg,png,gif','max:5120']
        ]);
        $file = $request->file('avatar');
        $name = 'u'.$user->id.'_'.time().'.'.$file->getClientOriginalExtension();
        $dest = public_path('uploads/avatars');
        if (!is_dir($dest)) @mkdir($dest, 0777, true);
        $file->move($dest, $name);
        $relative = 'uploads/avatars/'.$name;
        // optionally delete old file if it exists and within uploads/avatars
        if ($user->avatar_path && str_starts_with($user->avatar_path, 'uploads/avatars/') && file_exists(public_path($user->avatar_path))) {
            @unlink(public_path($user->avatar_path));
        }
        $user->avatar_path = $relative;
        $user->save();
        return response()->json(['message' => 'Avatar updated', 'url' => asset($relative)]);
    }
}


