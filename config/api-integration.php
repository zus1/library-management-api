<?php

return [
    'data_mappers' => [
        \App\Services\Api\CatsApi\Request\ImagesRequest::class => \App\Services\Api\CatsApi\DataMapper\ImagesDataMapper::class,
        \App\Services\Api\CatsApi\Request\VoteRequest::class => \App\Services\Api\CatsApi\DataMapper\VoteDataMapper::class
    ],
    'exception_handlers' => [

    ],
    'response_handlers' => [

    ],

    'error_log_channel' => env('API_ERROR_LOG', 'single')
];
