<?php

namespace App\Services\ElasticSearch\Factory;

use App\Services\ElasticSearch\Constant\AuthMode;
use App\Services\ElasticSearch\Constant\ConnectionMode;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class ClientFactory
{
    public function instance(): Client
    {
        $connectionMode = (string) config('elastic-search.connection_mode');
        $cloudAuthMode = (string) config('elastic-search.cloud_auth_mode');
        $log = (array) config('elastic-search.log');

        $builder = ClientBuilder::create()->setHosts(config('elastic-search.hosts'));

        if($connectionMode === ConnectionMode::CLOUD) {
            if($cloudAuthMode === AuthMode::BASIC_AUTH) {
                $this->attachBasicAuthentication($builder);
            }

            if($cloudAuthMode === AuthMode::API_KEY) {
                $this->attachApiKeyAuthentication($builder);
            }
        }

        if($connectionMode === ConnectionMode::LOCAL) {
            $this->attachLocalAuthentication($builder);
        }

        if($log['enabled'] === true) {
            $this->attachLogger($builder, $log['threshold']);
        }

        return $builder->build();
    }

    private function attachBasicAuthentication(ClientBuilder $builder): void
    {
        $user = (array) config('elastic-search.user');

        $username = $user['user'];
        $password = $user['password'];

        $builder->setBasicAuthentication($username, $password);
    }

    private function attachApiKeyAuthentication(ClientBuilder $builder): void
    {
        $cloudCredentials = (array) config('elastic-search.cloud_credentials');

        $apiKey = $cloudCredentials['api_key'];
        $apiId = $cloudCredentials['api_id'];

        $builder->setApiKey($apiKey, $apiId);
    }

    private function attachLocalAuthentication(ClientBuilder $builder): void
    {
        $ssl = (array) config('elastic_search.ssl');

        $this->attachBasicAuthentication($builder);

        if($ssl['enabled'] === true) {
            $builder->setSSLVerification();
            $builder->setSSLCert($ssl['ca_path']);
            $builder->setSSLKey($ssl['key_path']);
        }
    }

    private function attachLogger(ClientBuilder $builder, int|string $threshold): void
    {
        $logger = new Logger('elastic');
        $logger->pushHandler(new StreamHandler(storage_path('logs/elastic-search.log'), $threshold));

        $builder->setLogger($logger);
    }
}
