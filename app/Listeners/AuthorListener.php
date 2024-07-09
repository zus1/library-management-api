<?php

namespace App\Listeners;

use App\Const\RouteName;
use App\Models\Author;
use App\Repository\AuthorRepository;
use Illuminate\Http\Request;
use Zus1\Serializer\Event\NormalizedDataEvent;
use Zus1\Serializer\Normalizer\Normalizer;

class AuthorListener
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private Request $request,
        private AuthorRepository $repository,
    ){
    }

    /**
     * Handle the event.
     */
    public function handle(NormalizedDataEvent $event): void
    {
        $normalizer = $event->getNormalizer();
        $class = $event->getSubjectClass();

        if($class !== Author::class) {
            return;
        }

        if($this->request->route()->action['as'] === RouteName::AUTHORS) {
            $this->modifyNormalizedAuthors($normalizer);
        }
    }

    private function modifyNormalizedAuthors(Normalizer $normalizer): void
    {
        $data = $normalizer->getPaginatedCollection();

        $ids = array_map(function (array $author) {
            return $author['id'];
        }, $data->all());

        $authors = $this->repository->findByIds($ids);

        $collection = $data->map(function (array $author) use ($authors) {
            /** @var Author $authorObj */
            $authorObj = $authors->where('id', $author['id'])->first();

            $author['total_books'] = $authorObj->booksNum();

            return $author;
        });

        $data->setCollection($collection);

        $normalizer->setPaginatedCollection($data);
    }
}
