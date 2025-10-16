<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// get current user
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    $data = $request->user()->load('roles');
    $data['is_admin'] = $request->user()->hasRole(User::ADMIN_ROLE);
    return printJson($data, buildStatusObject('HTTP_OK'), $request->lang);
});

// api/v1 routes
Route::prefix('v1')->group(base_path('routes/api_v1.php'));

require __DIR__.'/auth.php';
