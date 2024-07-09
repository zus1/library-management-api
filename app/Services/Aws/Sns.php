<?php

namespace App\Services\Aws;

use Aws\Sns\SnsClient;
use Illuminate\Log\Logger;

class Sns
{
    public function __construct(
        private SnsClient $client,
        private Logger $logger,
    ){
    }

    public function sendSms(string $phoneNumber, string $message): bool
    {
        if($this->checkOptedOut($phoneNumber) === true) {
            $this->logger->info(sprintf('Phone number %s is opted out', $phoneNumber));

            return false;
        }

        $response = $this->client->publish([
            'PhoneNumber' => $phoneNumber,
            'Message' => $message
        ]);

        return $response->get('MessageId') !== null;
    }

    public function checkOptedOut(string $phoneNumber): bool
    {
        $response = $this->client->checkIfPhoneNumberIsOptedOut([
            'phoneNumber' => $phoneNumber
        ]);

        return $response->get('isOptedOut');
    }
}
