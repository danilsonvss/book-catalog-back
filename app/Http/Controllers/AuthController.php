<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

const AUTH_ERROR = 1;

class AuthController extends Controller
{
    public function auth(Request $request)
    {
        try {
            if (!Auth::attempt($request->only('email', 'password'))) {
                throw new Exception('Credencias de login inválidas', AUTH_ERROR);
            }

            $user = User::where('email', $request['email'])->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success'      => true,
                'access_token' => $token,
                'token_type'   => 'Bearer',
            ]);
        } catch (Exception $e) {
            // Parse only the API errors
            $message = $e->getCode() == AUTH_ERROR ? $e->getMessage() : 'Erro inesperado';

            return response()->json([
                'success' => false,
                'message' => $message
            ]);
        }
    }

    public function login()
    {
        return response()->json([
            'success' => false,
            'message' => 'Você precisa fazer login',
        ]);
    }

    public function user(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'Fim da sessão',
        ]);
    }
}
