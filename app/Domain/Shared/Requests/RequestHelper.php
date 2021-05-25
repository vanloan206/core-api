<?php

namespace App\Domain\Shared\Requests;

use Mi\Core\Rules\PositiveInt32;

class RequestHelper
{
    const INT_32_MAX = 2147483647;
    const INT_32_MIN = 1;
    const ORDER_DEFAULT_LENGTH = 100;
    const WITH_DEFAULT_LENGTH = 100;
    const PER_PAGE_DEFAULT_MAX = 200;

    /**
     * Common list rules
     *
     * @return array
     */
    public static function commonListRules()
    {
        return [
            'page' => [
                'bail',
                'sometimes',
                new PositiveInt32,
            ],
            'per_page' => [
                'bail',
                'sometimes',
                'integer',
                'min:' . self::INT_32_MIN,
                'max:' . self::PER_PAGE_DEFAULT_MAX
            ],
            'order' => [
                'bail',
                'sometimes',
                'string',
                'max:' . self::ORDER_DEFAULT_LENGTH
            ],
            'with' => [
                'bail',
                'sometimes',
                'string',
                'max:' . self::WITH_DEFAULT_LENGTH
            ],
            'next_cursor' => [
                'bail',
                'sometimes',
                'string'
            ],
        ];
    }

    /**
     * Common find rule
     *
     * @return array
     */
    public static function commonFindRules()
    {
        return [
            'with' => [
                'bail',
                'sometimes',
                'string',
                'max:' . self::WITH_DEFAULT_LENGTH
            ]
        ];
    }

    public static function commonListRulesDynamoDB()
    {
        return [
            'per_page' => [
                'sometimes',
                'integer',
                'min:' . self::INT_32_MIN,
                'max:' . self::PER_PAGE_DEFAULT_MAX
            ],
            'exclusive_start' => [
                'array',
                'sometimes'
            ],
            'with' => [
                'bail',
                'sometimes',
                'string',
                'max:' . self::WITH_DEFAULT_LENGTH
            ],
        ];
    }
}
