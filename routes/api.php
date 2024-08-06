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
            ->middleware('upload-owner-binding')
            ->where('owner', '[0-9]+');
        Route::delete('images/{owner}', \App\Http\Controllers\Image\Delete::class)
            ->name(RouteName::IMAGE_DELETE)
            ->where('owner', '[0-9]+');

        Route::post('/authors', \App\Http\Controllers\Author\Create::class)
            ->name(RouteName::AUTHOR_CREATE);
        Route::put('/authors/{author}', \App\Http\Controllers\Author\Update::class)
            ->name(RouteName::AUTHOR_UPDATE)
            ->where('author', '[0-9]+');
        Route::delete('/authors/{author}', \App\Http\Controllers\Author\Delete::class)
            ->name(RouteName::AUTHOR_DELETE)
            ->where('author', '[0-9]+');
        Route::get('/authors', \App\Http\Controllers\Author\RetrieveCollection::class)
            ->name(RouteName::AUTHORS);
        Route::get('/authors/{author}', \App\Http\Controllers\Author\Retrieve::class)
            ->name(RouteName::AUTHOR)
            ->where('author', '[0-9]+');

        Route::post('/books', \App\Http\Controllers\Book\Create::class)
            ->name(RouteName::BOOK_CREATE);
        Route::put('/books/{book}', \App\Http\Controllers\Book\Update::class)
            ->name(RouteName::BOOK_UPDATE)
            ->where('book', '[0-9]+');
        Route::delete('/books/{book}', \App\Http\Controllers\Book\Delete::class)
            ->name(RouteName::BOOK_DELETE)
            ->where('book', '[0-9]+');
        Route::get('/books', \App\Http\Controllers\Book\RetrieveCollection::class)
            ->name(RouteName::BOOKS);
        Route::get('/books/{book}',  \App\Http\Controllers\Book\Retrieve::class)
            ->name(RouteName::BOOK)
            ->where('book', '[0-9]+');
        Route::get('/books/search', \App\Http\Controllers\Book\Search::class)
            ->name(RouteName::BOOK_SEARCH);
        Route::get('/books/auto-complete', \App\Http\Controllers\Book\AutocompleteSearch::class)
            ->name(RouteName::BOOK_AUTOCOMPLETE);

        Route::post('/rentals/client/{client}/book/{book}', \App\Http\Controllers\Rental\Create::class)
            ->name(RouteName::RENTAL_CREATE)
            ->where('client', '[0-9]+')
            ->where('book', '[0-9]+');
        Route::put('/rentals/{rental}/extend', \App\Http\Controllers\Rental\Extend::class)
            ->name(RouteName::RENTAL_EXTEND)
            ->where('rental', '[0-9]+');
        Route::put('/rentals/{rental}/toggle-active', \App\Http\Controllers\Rental\ToggleActive::class)
            ->name(RouteName::RENTAL_TOGGLE_ACTIVE)
            ->where('rental', '[0-9]+');
        Route::get('/rentals', \App\Http\Controllers\Rental\RetrieveCollection::class)
            ->name(RouteName::RENTALS);
        Route::get('/rentals/{rental}', \App\Http\Controllers\Rental\Retrieve::class)
            ->name(RouteName::RENTAL)
            ->where('rental', '[0-9]+');

        Route::put('/fines/{fine}/change-status', \App\Http\Controllers\Fine\ChangeStatus::class)
            ->name(RouteName::FINE_CHANGE_STATUS)
            ->where('fine', '[0-9]+');
        Route::get('/fines', \App\Http\Controllers\Fine\RetrieveCollection::class)
            ->name(RouteName::FINES);
    });
});

Route::get('/cats/images', \App\Http\Controllers\Cat\ImagesCollection::class);
Route::post('/cats/vote', \App\Http\Controllers\Cat\Vote::class);

Route::prefix('auth')->group(function () {
    Route::post('/register', \App\Http\Controllers\Auth\Register::class)
        ->name(RouteName::REGISTER);
});
