<?php

namespace Mi\Core\Filters;

use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Mi\Core\Contracts\FilterInterface;

/** @SuppressWarnings(PHPMD.NumberOfChildren) */
abstract class BaseFilter implements FilterInterface
{
    public const DEFAULT_TIMEZONE = 'Asia/Tokyo';

    /**
     * @var \Illuminate\Support\Collection
     */
    protected static $grabInputs;

    /**
     * @var array
     */
    protected static $optionalInputs = [];

    /**
     * Grab other input for using in the filter
     *
     * @param \Illuminate\Support\Collection $data
     */
    public static function grabInputs(Collection $data)
    {
        self::$grabInputs = $data->only(self::$optionalInputs);
    }

    /**
     * Escape input type string for using in the filter ILIKE
     *
     * @param string $string
     *
     * @return string
     */
    public static function escapeString(string $string)
    {
        return addcslashes($string, '%_');
    }

    /**
     * check format string is Y-m-d
     *
     * @param string $string
     * @return boolean
     */
    private static function isDate(string $string)
    {
        $regex = '/^\d{2}(\d{2}(-|$)){3}/';

        return preg_match($regex, $string);
    }

    /**
     * Format datetime
     * If format is y-m-d
     * Then return $datetime
     * Else return $string
     *
     * @param string $string
     * @param \Carbon\CarbonInterface $datetime
     * @return \Carbon\CarbonInterface
     */
    public static function getDateTimeFormat(string $string, CarbonInterface $datetime)
    {
        return self::isDate($string) ? $datetime : new Carbon($string, self::DEFAULT_TIMEZONE);
    }

    /**
     * Apply the filter
     *
     * @param \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder $model
     * @param mixed $input
     * @return mixed
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public static function apply($model, $input)
    {
        return $model;
    }
}
