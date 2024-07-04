<?php

return [
    'access_key' => env('AWS_ACCESS_KEY_ID'),
    'secret_key' => env('AWS_SECRET_ACCESS_KEY'),

    's3' => [
        'region' => env('AWS_S3_DEFAULT_REGION'),
        'bucket' => env('AWS_S3_BUCKET'),
        'url' => env('AWS_S3_URL'),
        'version' => env('AWS_S3_VERSION'),
    ],
];
