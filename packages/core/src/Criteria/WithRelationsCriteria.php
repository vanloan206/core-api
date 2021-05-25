<?php

namespace Mi\Core\Criteria;

use Mi\Core\Contracts\CriteriaInterface;
use Mi\Core\Contracts\RepositoryInterface;

/**
 * Class WithRelationsCriteriaCriteria.
 *
 * @package Mi\Core\Criteria;
 */
class WithRelationsCriteria implements CriteriaInterface
{
    /**
     * List of request relations from query string
     *
     * @var array
     */
    protected $input;

    /**
     * List of allow relations
     *
     * @var array|null
     */
    protected $allows;

    /**
     * An constructor of WithRelationsCriteria
     *
     * @param mixed $input
     * @param array|null $allows
     */
    public function __construct($input = '', $allows = null)
    {
        $this->input = array_filter(
            array_map(
                '\Illuminate\Support\Str::camel',
                is_array($input) ? $input : explode(',', $input)
            )
        );

        $this->allows = $allows;
    }

    /**
     * Apply criteria in query repository
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param \Mi\Core\Contracts\RepositoryInterface $repository
     *
     * @return mixed
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $withs = [];

        if (is_null($this->allows)) {
            $this->allows = $repository->allowableRelations();
        }

        foreach ($this->allows as $key => $value) {
            if (! in_array(is_numeric($key) ? $value : $key, $this->input)) {
                continue;
            }

            if (is_array($value)) {
                $withs[$value[0]] = $value[1] ?? function () {
                    //
                };
                continue;
            }

            $withs[$key] = $value;
        }

        return empty($withs) ? $model : $model->with($withs);
    }
}
