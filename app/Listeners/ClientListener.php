<?php

namespace App\Listeners;

use App\Const\RouteName;
use App\Models\Client;
use App\Repository\ClientRepository;
use Illuminate\Http\Request;
use Zus1\Serializer\Event\NormalizedDataEvent;
use Zus1\Serializer\Normalizer\Normalizer;

class ClientListener
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private Request $request,
        private ClientRepository $repository,
    ){
    }

    /**
     * Handle the event.
     */
    public function handle(NormalizedDataEvent $event): void
    {
        $subjectClass = $event->getSubjectClass();

        if($subjectClass !== Client::class) {
            return;
        }

        if($this->request->route()->action['as'] === RouteName::CLIENT) {
            $this->modifyNormalizedData($event);
        }
    }

    private function modifyNormalizedData(NormalizedDataEvent $event): void
    {
        /** @var Normalizer $normalizer */
        $normalizer = $event->getNormalizer();
        $data = $normalizer->getNormalizedData();

        /** @var Client $client */
        $client = $this->repository->findOneByOr404(['id' => $data['id']]);
        $data['total_fine_amount'] = $client->pendingFinesAmount();

        $normalizer->setNormalizedData($data);
    }
}
