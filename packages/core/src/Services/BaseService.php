<?php

namespace Mi\Core\Services;

use Closure;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Mi\Core\Contracts\RepositoryInterface;

/** @SuppressWarnings(PHPMD.NumberOfChildren) */
abstract class BaseService
{
    /**
     * @var boolean
     */
    protected $collectsData = true;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $service;

    /**
     * @var \Illuminate\Database\Eloquent\Model|null
     */
    protected $activeRole;

    /**
     * @var int|string
     */
    protected $modelId;

    /**
     * @var \Illuminate\Support\Collection|array
     */
    protected $data;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $handler;

    /**
     * Set the data
     *
     * @param mixed $data
     * @return self
     */
    public function setData($data)
    {
        $this->data = ($data instanceof Collection || ! $this->collectsData) ? $data : new Collection($data);

        return $this;
    }

    /**
     * Set the handler
     *
     * @param \Illuminate\Database\Eloquent\Model $handler
     * @return self
     */
    public function setHandler($handler)
    {
        $this->handler = $handler;

        return $this;
    }

    /**
     * Set the handler
     *
     * @param \Illuminate\Database\Eloquent\Model|int|string $model
     * @return self
     */
    public function setModel($model)
    {
        if ($model instanceof Model) {
            $this->model = $model;
        }

        if (! $model instanceof Model) {
            $this->modelId = $model;
        }

        return $this;
    }

    /**
     * @var \Illuminate\Database\Eloquent\Model $service
     */
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @var \Illuminate\Database\Eloquent\Model|null $activeRole
     */
    public function setActiveRole($activeRole)
    {
        $this->activeRole = $activeRole;

        return $this;
    }

    /**
     * Set the request to service
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @return self
     */
    public function setRequest($request)
    {
        $this->setHandler($request->user());
        $this->setData($request->validated());
        $this->setService($request->offsetGet('service'));
        $this->setActiveRole($request->get('activeRole'));

        return $this;
    }

    abstract public function handle();

    /**
     * Get default pagination limit
     *
     * @return integer
     */
    protected function getPerPage()
    {
        return $this->data['per_page'] ?? 50;
    }

    /**
     * Initialize all of the bootable traits on the model.
     *
     * @return void
     */
    protected function initializeTraits()
    {
        $class = static::class;

        foreach (\class_uses_recursive($class) as $trait) {
            if (method_exists($class, $method = 'initialize' . class_basename($trait))) {
                $this->$method();
            }
        }
    }

    /**
     * Check that the service requires additional relation
     *
     * @param string $name
     * @return bool
     */
    protected function isRequiredRelation(string $name)
    {
        return (bool) preg_match('/(?<=^|,)' . $name . '(?=,|$)/', $this->data->get('with'));
    }

    /**
     * Attach fields to result
     *
     * @param mixed $data
     * @param Closure $callback
     * @return mixed
     */
    protected function attachFieldsToResult(&$data, Closure $callback)
    {
        if ($data instanceof EloquentCollection) {
            return $callback($data);
        }

        return $data;
    }

    /**
     * Get paginated result or all
     *
     * @param \Mi\Core\Contracts\RepositoryInterface $repository
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    protected function paginateOrAll(RepositoryInterface $repository)
    {
        return $this->data->has('per_page')
            ? $repository->paginate($this->getPerPage())
            : $repository->all();
    }

    /**
     * Attach fields to current data
     *
     * @param array $data
     * @param array $options
     * @return array
     */
    protected function transformDataForInsert(array $data, array $options)
    {
        return array_map(function ($row) use ($options) {
            return array_merge($row, $options);
        }, $data);
    }
}
