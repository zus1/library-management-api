<?php

namespace App\Services\Aws;

use Aws\S3\BatchDelete;
use Aws\S3\S3Client;
use Illuminate\Cache\Repository;

class S3
{
    public function __construct(
        private S3Client $client,
        private Repository $cache,
        private string $bucket = '',
    )
    {
        $this->bucket = config('aws.s3.bucket');
    }

    public function put(string $filename, string $filePath): string
    {
        $response = $this->client->putObject([
            'Bucket' => $this->bucket,
            'Key' => $filename,
            'SourceFile' => $filePath
        ]);

        return $response->get('ObjectURL');
    }

    public function deleteMany(array $filenames): bool
    {
        $filenames = array_map(function (string $filename) {
            return ['Key' => $filename];
        }, $filenames);

        $response = $this->client->deleteObjects([
            'Bucket' => $this->bucket,
            'Delete' => [
                'Objects' => $filenames,
            ],
        ]);

        return count($response->get('Deleted')) === count($filenames);
    }

    public function delete(string $filename): bool
    {
        $this->client->deleteObject([
            'Bucket' => $this->bucket,
            'Key' => $filename
        ]);

        return $this->client->doesObjectExistV2($this->bucket, $filename);
    }

    public function signedUrl(string $filename, string $ttl): string
    {
        if(($cached = $this->cache->get($filename)) !== null) {
            return $cached;
        }

        $newSignedUrl = $this->getNewSignedUrl($filename, $ttl);

        $this->cache->put($filename, $newSignedUrl, ($ttl = $this->convertAwsTtlToRedis($ttl)) > 0 ? $ttl -1 : 1);

        return $newSignedUrl;
    }

    public function url(string $filename): string
    {
        return $this->client->getObjectUrl(
            bucket: $this->bucket,
            key: $filename,
        );
    }

    private function getNewSignedUrl(string $filename, string $ttl): string
    {
        $command = $this->client->getCommand('GetObject', [
            'Bucket' => $this->bucket,
            'Key' => $filename,
        ]);

        $signedRequest =  $this->client->createPresignedRequest($command, $ttl);

        return sprintf('%s://%s%s?%s',
            $signedRequest->getUri()->getScheme(),
            $signedRequest->getUri()->getHost(),
            $signedRequest->getUri()->getPath(),
            $signedRequest->getUri()->getQuery()
        );
    }

    private function convertAwsTtlToRedis(string $awsTtl): int
    {
        return (int) explode(' ', $awsTtl)[0] * 60;
    }
}
