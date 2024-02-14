<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $this->validatelogin($request);

        if( Auth::attempt($request->only('email', 'password')))
        {
            return response()->json([
                'token'     => $request->user()->createToken($request->name)->plainTextToken,
                'message'   => 'Success'
            ]);
        }

        return response()->json([
            'message' => 'Unauthorized'
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function validatelogin(Request $request)
    {

        return $request->validate([
            'email'     => 'required | email',
            'password'  => 'required',
            'name'      => 'required'
        ]);
    }
}
