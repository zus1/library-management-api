<?php

use App\Const\RouteName;
use Zus1\LaravelAuth\Constant\TokenType;

return [
    'user_namespace' => env('LARAVEL_AUTH_USER_NAMESPACE', 'App\Models'),
    'user_class' => sprintf(
        '%s\\%s',
        env('LARAVEL_AUTH_USER_NAMESPACE', 'App\Models'),
        env('LARAVEL_AUTH_USER_CLASS', 'Librarian')
    ),

    'token' => [
        'expires_in' => [
            'access_token' => 30 * 24 * 60,
            'refresh_token' => 60 * 24 * 60,
            'user_verification_token' => 60,
            'reset_password_token' => 30,
        ],
        'length' => [
            'access_token' => 100,
            'refresh_token' => 100,
            'user_verification_token' => 50,
            'reset_password_token' => 50,
        ],
        'type_class' => TokenType::class,
        'request_header' => 'Authorization'
    ],
    'email' => [
        'subject' => [
            'verification' => 'Email verification',
            'reset_password' => 'Reset Password',
            'welcome' => 'Welcome'
        ],
        'templates' => [
            'verification' => [
                'txt' => 'mail/authentication::verify-txt',
                'markdown' => 'mail/authentication::verify'
            ],
            'reset_password' => [
                'txt' => 'mail/authentication::reset-password-txt',
                'markdown' => 'mail/authentication::reset-password'
            ],
            'welcome' => [
                'txt' => 'mail/authentication::welcome-txt',
                'markdown' => 'mail/authentication::welcome'
            ]
        ],
    ],

    'authorization' => [
        'mapping' => [
            RouteName::LIBRARIANS => 'pass',
            RouteName::RETRIEVE_LIBRARIAN => 'pass',
            RouteName::LIBRARIAN_TOGGLE_ACTIVE => 'pass',
            RouteName::CLIENT_CREATE => 'pass',
            RouteName::CLIENT_UPDATE => 'pass',
            RouteName::CLIENT_DELETE => 'pass',
            RouteName::CLIENTS => 'pass',
            RouteName::CLIENT => 'pass',
            RouteName::IMAGE_UPLOAD => 'pass',
            RouteName::AUTHORS => 'pass',
            RouteName::AUTHOR => 'pass',
            RouteName::AUTHOR_CREATE => 'pass',
            RouteName::AUTHOR_UPDATE => 'pass',
            RouteName::AUTHOR_DELETE => 'pass',
            RouteName::BOOK => 'pass',
            RouteName::BOOKS => 'pass',
            RouteName::BOOK_CREATE => 'pass',
            RouteName::BOOK_UPDATE => 'pass',
            RouteName::BOOK_DELETE => 'pass',
            RouteName::RENTAL => 'pass',
            RouteName::RENTALS => 'pass',
            RouteName::RENTAL_CREATE => 'pass',
            RouteName::RENTAL_TOGGLE_ACTIVE => 'pass',
            RouteName::RENTAL_EXTEND => 'pass',
            RouteName::FINES => 'pass',
            RouteName::FINE_CHANGE_STATUS => 'pass'
        ],
        'possible_route_parameters' => [
            'client', 'author', 'book', 'rental', 'fine'
        ],
        'additional_subjects' => [
            RouteName::CLIENT_CREATE => \App\Models\Client::class,
            RouteName::IMAGE_UPLOAD => \App\Models\Image::class,
            RouteName::AUTHOR_CREATE => \App\Models\Author::class,
            RouteName::AUTHORS => \App\Models\Author::class,
            RouteName::BOOK_CREATE => \App\Models\Book::class,
            RouteName::BOOKS => \App\Models\Book::class,
            RouteName::RENTAL_CREATE => \App\Models\Rental::class,
            RouteName::FINES => \App\Models\Fine::class,
        ],
    ]
];
