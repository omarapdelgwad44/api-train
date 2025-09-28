<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Login;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AuthController extends Controller
{
    use \App\Traits\ApiResponse;

    public function login(Login $request) {

        $request->validated(request()->all());

        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error('Invalid credentials', 401);
        }
         $user = User::firstWhere('email', $request->email);
        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token')->plainTextToken
        ]);
    }
}
