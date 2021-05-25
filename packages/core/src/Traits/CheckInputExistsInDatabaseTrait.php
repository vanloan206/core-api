<?php

namespace Mi\Core\Traits;

use Closure;
use Illuminate\Support\Facades\DB;

trait CheckInputExistsInDatabaseTrait
{
    /**
     * Ensure input is exists in database
     *
     * @param string $input
     * @param string $tableName
     * @param string $fieldName
     * @param \Closure $callback
     * @return bool
     */
    protected function inputMustBeExistsInDatabase(string $input, string $tableName, string $fieldName, Closure $callback = null)
    {
        $data = $this->input($input);

        if (empty($data)) {
            return true;
        }

        $query = DB::table($tableName)->whereIn($fieldName, $data);
        if (is_callable($callback)) {
            $query->when(true, $callback);
        }

        return $query->count() == count(array_unique($data));
    }
}
