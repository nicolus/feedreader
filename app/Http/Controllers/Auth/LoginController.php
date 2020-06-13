<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{

    public function statefulLogin(Request $request)
    {
        if (Auth::attempt($request->only(['email', 'password']))) {
            return response(["success" => true], 200);
        } else {
            return response(["success" => false], 503);
        }
    }

    public function token(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
                'device_name' => 'required'
            ]
        );

        /** @var User $user */
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages(
                [
                    'email' => ['The provided credentials are incorrect.'],
                ]
            );
        }

        $token = $user->createToken($request->device_name)->plainTextToken;

        return ['access_token' => $token];
    }
}
