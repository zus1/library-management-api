<?php

namespace App\Trait;

use App\Interface\CanBeActiveInterface;
use Illuminate\Database\Eloquent\Model;

trait ModelCanBeActive
{
    public function toggleActive(CanBeActiveInterface&Model $model, bool $active): Model
    {
        $model->setActive($active);

        $model->save();

        return $model;
    }
}
