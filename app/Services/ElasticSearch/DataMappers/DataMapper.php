<?php

namespace App\Services\ElasticSearch\DataMappers;

use App\Models\Book;
use App\Services\ElasticSearch\Constant\Pagination;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class DataMapper
{
    public function __construct(
        private Request $request
    ){
    }

    public function map(array $data): Collection|LengthAwarePaginator
    {
        $hits = $data['hits']['hits'];
        $modelClass = $this->getModelClass($hits[0]['_index']);

        $models = array_map(function (array $hit) use ($modelClass) {
            /** @var Book $model */
            $model = new $modelClass();
            $this->setModelRelations($model, $hit['_source']);
            $this->setModelAttributes($model, $hit['_source']);

            return $model;
        }, $hits);

        if(isset($data['_scroll_id']) && $this->request->query('page') !== null) {
            return new LengthAwarePaginator(
                $models,
                $data['hits']['total']['value'],
                $this->request->query('size', Pagination::DEFAULT_SIZE),
                $this->request->query('page'),
            );
        }

        return new Collection($models);
    }

    private function getModelClass(string $index): string
    {
        return sprintf('App\\Models\\%s', ucfirst(Str::singular($index)));
    }

    private function setModelRelations(Model $model, array $source): void
    {
        array_walk($source, function (mixed $value, string $key) use ($model) {
            if(is_array($value)) {
                count($value) === 1 ?
                    $model->setRelation($key, $this->mapSingleRelation($key, $value[0])) :
                    $model->setRelation($key, $this->mapRelationCollection($key, $value));
            }
        });
    }

    private function mapSingleRelation(string $key, array $relation): Model
    {
        $relationClass = $this->getModelClass($key);

        /** @var Model $relationModel */
        $relationModel = new $relationClass();

        $relationModel->setRawAttributes($relation);

        return $relationModel;
    }

    private function mapRelationCollection(string $key, array $relations): Collection
    {
        $relationClass = $this->getModelClass($key);

        $relationModels = array_map(function (array $relation) use ($relationClass) {
            /** @var Model $relationModel */
            $relationModel = new $relationClass();
            return $relationModel->setRawAttributes($relation);
        }, $relations);

        return new Collection($relationModels);
    }

    private function setModelAttributes(Model $model, array $source): void
    {
        $attributes = [];
        array_walk($source, function (mixed $value, string $key) use (&$attributes) {
            if(!is_array($value)) {
                $attributes[$key] = $value;
            }
        });

        $model->setRawAttributes($attributes);
    }
}
