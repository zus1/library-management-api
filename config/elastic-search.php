<?php

use Zus1\Elasticsearch\Constant\AuthMode;
use Zus1\Elasticsearch\Constant\ConnectionMode;


return [

    /**
     * List of hosts to be used when connecting
     */
    'hosts' => explode(',', env('ELASTICSEARCH_HOST', 'https://localhost:9200')),

    /**
     * Where to connect local instance or cloud
     * Can be set to local or cloud
     */
    'connection_mode' => env('ELASTICSEARCH_CONNECTION_MODE', ConnectionMode::CLOUD),

    /**
     * How to authenticate with elastic cloud.
     * Can be set to basic_auth or api_key
     */
    'cloud_auth_mode' => env('ELASTICSEARCH_CLOUD_AUTH_MODE', AuthMode::API_KEY),

    /**
     * Needed when connection_mode is set to local or when cloud_auth_mode is set to basic_auth
     */
    'user' => [
        'user' => env('ELASTICSEARCH_USER'),
        'password' => env('ELASTICSEARCH_PASSWORD'),
    ],

    /**
     * When connecting via api key
     * Follow https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/connecting.html to create api key
     * Decode it (base64_decode()), decoded key will have format api_id:api_key
     */
    'cloud_credentials' => [
        'api_id' => env('ELASTICSEARCH_API_ID', ''),
        'api_key' => env('ELASTICSEARCH_API_KEY', ''),
    ],

    /**
     * Need if your local elasticsearch instance requires ssl for connecting
     */
    'ssl' => [
        'enabled' => env('ELASTICSEARCH_SSL_ENABLED', false),
        'ca_path' => env('ELASTICSEARCH_CA_PATH'),
        'key_path' => env('ELASTICSEARCH_CA_KEY_PATH')
    ],

    /**
     *  Enables/disables logging for elastic search client. Enabling may lower performance
     *  https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/enabling_logger.html
     *  Logger will be injected automatically
     *  Threshold is minimal level to log, for example if threshold is warning then info and debug won't be logged
     *  Depends on chosen logger, by default is Monolog Info - 200
     */
    'log' => [
        'enabled' => env('ELASTICSEARCH_LOG_ENABLED', false),
        'threshold' => env('ELASTICSEARCH_LOG_THRESHOLD', 200)
    ],


    /**
     * Can be used for index creating in elastic search, for convenience
     */
    'indexes' => [
        'book' => [
            'id' => [
                'type' => 'keyword'
            ],
            'title' => [
                'type' => 'text',
            ],
            'isbn' => [
                'type' => 'keyword',
            ],
            'dimensions' => [
                'type' => 'text',
            ],
            'num_of_pages' => [
                'type' => 'integer'
            ],
            'cover_type' => [
                'type' => 'text',
            ],
            'year_of_release' => [
                'type' => 'text',
            ],
            'edition' => [
                'type' => 'integer'
            ],
            'genre' => [
                'type' => 'text',
            ],
            'type' => [
                'type' => 'text',
            ],
            'author' => [
                'type' => 'nested',
            ],
        ],
    ],
];
