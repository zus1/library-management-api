<?php

namespace App\Const;

class RouteName
{
    public const REGISTER = 'register';

    public const LIBRARIANS = 'librarians';
    public const RETRIEVE_LIBRARIAN = 'retrieve_librarian';
    public const LIBRARIAN_TOGGLE_ACTIVE = 'librarian_toggle_active';

    public const CLIENT_CREATE = 'client_create';
    public const CLIENT_UPDATE = 'client_update';
    public const CLIENT_DELETE = 'client_delete';
    public const CLIENTS = 'clients';
    public const CLIENT = 'client';

    public const IMAGE_UPLOAD = 'image_upload';
    public const IMAGE_DELETE = 'image_delete';

    public const AUTHORS = 'authors';
    public const AUTHOR = 'author';
    public const AUTHOR_CREATE = 'author_create';
    public const AUTHOR_UPDATE = 'author_update';
    public const AUTHOR_DELETE = 'author_delete';

    public const BOOKS = 'books';
    public const BOOK = 'book';
    public const BOOK_CREATE = 'book_create';
    public const BOOK_UPDATE= 'book_update';
    public const BOOK_DELETE = 'book_delete';

    public const RENTAL = 'rental';
    public const RENTALS = 'rentals';
    public const RENTAL_CREATE = 'rental_create';
    public const RENTAL_EXTEND = 'rental_extend';
    public const RENTAL_TOGGLE_ACTIVE = 'rental_toggle_active';

    public const FINES = 'fines';
    public const FINE_CHANGE_STATUS = 'fine_change_status';
}
