<?php

namespace App\Abstracts;

use App\Abstracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @desc a abstract general class for repository pattern based on the the RepositoryInterface
 * Class BaseRepository
 * @package App\Abstracts
 */
abstract class BaseRepository implements RepositoryInterface
{

    protected Model $model;

    /**
     * __constructor
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function get(): Collection
    {
        return $this->model->get();
    }

    public function filter($filters): Builder
    {
        return $this->model->where($filters);
    }

    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        return $this->model->where($column, $operator, $value, $boolean);
    }

    public function whereIn($columnName, $columnValues)
    {
        return $this->model->whereIn($columnName, $columnValues);
    }

    public function query()
    {
        return $this->model->newQuery();
    }
}
