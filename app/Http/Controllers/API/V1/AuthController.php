<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {
        $validated = $request->safe()->only(['email', 'password']);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || ! Hash::check($validated['password'], $user->password)) {
            return response()->json([
                "status" => Response::HTTP_BAD_REQUEST,
                "message" => "The provided credentials are incorrect.",
                "data" => null
            ], Response::HTTP_BAD_REQUEST);
        }

        $user->token = $user->createToken('glover')->plainTextToken;

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Login is successful',
            'data' => $user
        ], Response::HTTP_OK);

    }

}
