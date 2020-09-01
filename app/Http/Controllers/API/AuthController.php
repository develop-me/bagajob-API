<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\API\RegistrationRequest;

class AuthController extends Controller
{
    // registration
    public function register(RegistrationRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
 
        $token = $user->createToken('bagajob-API')->accessToken;
 
        return response()->json(['success' => [ 'token' => $token ]], 200);
    }
}
