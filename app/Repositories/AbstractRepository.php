<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Container\BindingResolutionException;

abstract class AbstractRepository
{
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * @throws BindingResolutionException|BindingResolutionException
     */
    public function __construct()
    {
        $this->model = app()->make($this->model());
    }

    abstract public function model(): string;

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        if (isset($this->query)) {
            return $this->query;
        }

        return $this->model->newQuery();
    }
}
