<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Responses\TokenResponse;
use App\Models\User;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/tokens/create', function () {
    $user = User::first();

    if (!$user) {
        return new TokenResponse(
            message: 'User not found.',
            status: 404
        );
    }

    Auth::login(user: $user);

    $token = $user->createToken(
        name: 'auto-login-token'
    )->plainTextToken;

    return new TokenResponse(
        message: 'User successfully logged in!',
        token: $token
    );
});
