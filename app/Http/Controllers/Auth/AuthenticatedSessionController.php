<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request) : JsonResponse
    {
        $request->authenticate();

        $user = $request->user()->load('roles');
        // Revoke all tokens...
        $user->tokens()->delete();

        $newToken = $user->createToken('api-token');

        // generate new token
        $dataUser = $user;
        $dataUser['is_admin'] = $user->hasRole(User::ADMIN_ROLE);
        $result = [
            'user' => $dataUser,
            'token' => $newToken->plainTextToken
        ];

        return printJson($result, buildStatusObject('HTTP_OK'), $this->lang);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $user = $request->user();
        $user->tokens()->delete();
        
        return printJson(null, null, $this->lang);
    }
}
