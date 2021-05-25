<?php

namespace Mi\Core\Criteria;

use Mi\Core\Contracts\CriteriaInterface;
use Mi\Core\Contracts\RepositoryInterface;

/**
 * Class NewOrderCriteriaCriteria.
 *
 * @package Mi\Core\Criteria;
 */
class OrderCriteria implements CriteriaInterface
{
    /**
     * @var array $order
     */
    protected $orders;

    /**
     * @var array $options
     */
    protected $options;

    /**
     * Instance of Order2Criteria
     *
     * @param array|string $input
     */
    public function __construct($input, $options = [])
    {
        $this->orders = array_filter(is_array($input) ? $input : explode(',', $input));
        $this->options = $options;
    }

    /**
     * Apply criteria in query repository
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $orderableFields = $repository->orderableFields();

        if (! empty($this->options)) {
            $orderableFields = array_merge($this->options, $orderableFields);
        }

        if (empty($orderableFields)) {
            return $model;
        }

        if (empty($this->orders)) {
            return $model->orderByDesc($orderableFields[0]);
        }

        $orderableFieldKeys = array_filter(array_keys($orderableFields), function ($v) {
            return is_string($v);
        });

        foreach ($this->orders as $o) {
            $desc  = $o[0] === '-';
            $field = $desc ? substr($o, 1) : $o;

            if (! in_array($field, $orderableFields) && ! in_array($field, $orderableFieldKeys)) {
                continue;
            }

            if (isset($orderableFields[$field])) {
                $field = $orderableFields[$field];
            }

            $model = $desc ? $model->newOrderByDesc($field, 'DESC NULLS LAST') : $model->orderBy($field);
        }

        return $model;
    }
}
