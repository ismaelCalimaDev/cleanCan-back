<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function getLoggedUserProfile()
    {
        return response()->json([
            'status' => true,
            'profile' => auth()->user(),
        ]);
    }
    public function updateProfile(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required'

        ]);
        auth()->user()->update([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'phone_number' => $validate['phone_number'],
        ]);

        return response()->json([
            'status' => true,
            'profile' => auth()->user(),
        ]);
    }
}
