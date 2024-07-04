<?php

use App\Const\RouteName;
use Illuminate\Support\Facades\Route;

Route::middleware('custom-auth')->group(function () {
    Route::middleware('custom-authorize')->group(function () {
        Route::get('/librarians', \App\Http\Controllers\Librarian\RetrieveCollection::class)
            ->name(RouteName::LIBRARIANS);
        Route::get('/librarians/{librarian}', \App\Http\Controllers\Librarian\Retrieve::class)
            ->name(RouteName::RETRIEVE_LIBRARIAN)
            ->where('librarian', '[0-9]+');
        Route::put('/librarians/{librarian}/toggle-active', \App\Http\Controllers\Librarian\ToggleActive::class)
            ->name(RouteName::LIBRARIAN_TOGGLE_ACTIVE)
            ->where('librarian', '[0-9]+');

        Route::post('/clients', \App\Http\Controllers\Client\Create::class)
            ->name(RouteName::CLIENT_CREATE);
        Route::put('/clients/{client}', \App\Http\Controllers\Client\Update::class)
            ->name(RouteName::CLIENT_UPDATE)
            ->where('client', '[0-9]+');
        Route::get('/clients', \App\Http\Controllers\Client\RetrieveCollection::class)
            ->name(RouteName::CLIENTS);
        Route::get('/clients/{client}', \App\Http\Controllers\Client\Retrieve::class)
            ->name(RouteName::CLIENT)
            ->where('client', '[0-9]+');
        Route::delete('/clients/{client}', \App\Http\Controllers\Client\Delete::class)
            ->name(RouteName::CLIENT_DELETE)
            ->where('client', '[0-9]+');

        Route::post('images/{owner?}', \App\Http\Controllers\Image\Upload::class)
            ->name(RouteName::IMAGE_UPLOAD)
            ->where('owner', '[0-9]+');
        Route::delete('images/{owner}', \App\Http\Controllers\Image\Delete::class)
            ->name(RouteName::IMAGE_DELETE)
            ->where('owner', '[0-9]+');
    });
});

Route::prefix('auth')->group(function () {
    Route::post('/register', \App\Http\Controllers\Auth\Register::class)
        ->name(RouteName::REGISTER);
});
