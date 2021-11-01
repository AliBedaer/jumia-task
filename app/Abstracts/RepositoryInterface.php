<?php

namespace App\Abstracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @desc a contract for repository pattern for the only used functions
 * Interface RepositoryInterface
 * @package App\Abstracts
 */
interface RepositoryInterface
{
    public function get(): Collection;
    public function filter($filters): Builder;
    public function where($column, $operator = null, $value = null, $boolean = 'and');
    public function whereIn($columnName, $columnValues);
    public function query();
}
