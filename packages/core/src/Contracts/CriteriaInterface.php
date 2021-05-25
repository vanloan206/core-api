<?php

namespace Mi\Core\Contracts;

use Mi\Core\Contracts\RepositoryInterface;

interface CriteriaInterface
{
    /**
     * Apply the criteria
     *
     * @param \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder $model
     * @param \Mi\Core\Contracts\RepositoryInterface $repository
     * @return void
     */
    public function apply($model, RepositoryInterface $repository);
}
