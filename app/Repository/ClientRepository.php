<?php

namespace App\Repository;

use App\Models\Client;

class ClientRepository extends UserRepository
{
    protected const MODEL = Client::class;

    public function __construct(
        private LibraryCardRepository $libraryCardRepository
    ){
    }

    public function create(array $data): Client
    {
        $client = new Client();

        $this->setSharedData($client, $data);

        $client->save();

        if(isset($data['library_card'])) {
            $libraryCard = $this->libraryCardRepository->create($data['library_card']);

            $client->libraryCard()->save($libraryCard);
        }

        return $client;
    }

    public function update(array $data, Client $client): Client
    {
        $this->setSharedData($client, $data);

        $client->save();

        return $client;
    }

    private function setSharedData(Client $client, array $data): void
    {
        $client->preferences = json_encode($data['preferences']);
        $client->phone_number = $data['phone_number'];

        $this->setBaseData($client, $data);
    }
}
