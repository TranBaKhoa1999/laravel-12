<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

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
        $user = $request->user();
        $token = $request->user()->currentAccessToken();
        
        // Check if token is a PersonalAccessToken (stateless) or TransientToken (stateful)
        if ($token instanceof PersonalAccessToken) {
            // Stateless API: revoke the current token
            $token->delete();
        } else {
            // Stateful API: revoke all tokens for the user
            $user->tokens()->delete();
        }
        
        return printJson(null, null, $this->lang);
    }
}
