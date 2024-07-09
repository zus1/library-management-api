<?php

namespace App\Providers;

use Aws\Credentials\CredentialProvider;
use Aws\Credentials\Credentials;
use Aws\S3\S3Client;
use Aws\Sns\SnsClient;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AwsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(S3Client::class, function (Application $app) {
            return new S3Client([
                'region' => config('aws.s3.region'),
                'version' => config('aws.s3.version'),
                'credentials' => $this->getCredentials()
            ]);
        });

        $this->app->bind(SnsClient::class, function (Application $app) {
            return new SnsClient([
                'region' => config('aws.sns.region'),
                'version' => config('aws.sns.version'),
                'credentials' => $this->getCredentials(),
            ]);
        });
    }

    private function getCredentials(): callable
    {
        return CredentialProvider::fromCredentials(new Credentials(
            key: config('aws.access_key'),
            secret: config('aws.secret_key'),
        ));
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
