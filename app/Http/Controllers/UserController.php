<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserController extends Controller {
    public function sanctum(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($request->device_name);

        return response()->json([
            'message' => 'User authenticated',
            'token' => $token->plainTextToken
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'birthdate' => 'required',
            'country_id' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birthdate' => $request->birthdate,
            'country_id' => $request->country_id,
        ]);

        return response()->json([
            'message' => 'User created'
        ]);
    }

    public function show(Request $request) {
        return response()->json([
            'data' => $request->user(),
        ]);
    }
}
