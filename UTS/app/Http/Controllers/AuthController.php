<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Membuat fitur register
    public function register(Request $request)
    {
        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];

        $user = User::create($input);

        $data = [
            'message' => 'User is created successfully',
        ];

        return response()->json($data, 200);

        //
    }

    // Membuat fitur login
    public function login(Request $request)
    {
        $input = [
            'email' => $request->email,
            'password' => $request->password
        ];
        // Mengambil data user
        $user = User::where('email', $input['email'])->first();

        // Membandingkan input user dengan data user (DB)
        $isLoginSuccessfully = (
            $input['email'] == $user->email &&
            Hash::check($input['password'], $user->password)
        );

        if ($isLoginSuccessfully) {

            $token = $user->createToken('auth_token');

            $data = [
                'message' => 'Login berhasil',
                'token' => $token->plainTextToken
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Username or password is wrong',
            ];
            return response()->json($data, 401);
        }
    }
}
