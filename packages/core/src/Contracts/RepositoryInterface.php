<?php

namespace Mi\Core\Contracts;

interface RepositoryInterface
{
    /**
     * Get list of filterable fields
     *
     * @return array
     */
    public function filterableFields();

    /**
     * Get list of filterable fields
     *
     * @return array
     */
    public function orderableFields();

    /**
     * Get list of allowable relations
     *
     * @return array
     */
    public function allowableRelations();

    /**
     * Find record by id
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find($id, array $columns = ['*']);

    /**
     * Get first record of repository
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function first($columns = ['*']);

    /**
     * Get all data of repository
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(array $columns = ['*']);

    /**
     * Get data of repository by pagination
     *
     * @param array $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $limit = null, array $columns = ['*']);

    /**
     * Get data of repository by pagination
     *
     * @param array $columns
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function simplePaginate(int $limit = null, array $columns = ['*']);

    /**
     * Get all data of repository by field
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findByField($field, $value, array $columns = ['*']);

    /**
     * Get all data of repository by condition
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findWhereIn($field, $value, array $columns = ['*']);

    /**
     * Create new model
     *
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $attributes);

    /**
     * Update the existed model
     *
     * @param mixed $id
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($id, array $attributes);

    /**
     * Remove the existed model
     *
     * @param mixed $id
     * @return boolean
     */
    public function delete($id);

    /**
     * Insert new records
     * @param array $values
     * @return boolean
     */
    public function insert(array $values);
}
