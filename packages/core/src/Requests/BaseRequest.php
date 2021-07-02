<?php

namespace Mi\Core\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Mi\Core\Rules\PositiveInt32;

/** @SuppressWarnings(PHPMD.NumberOfChildren.minimum) */
abstract class BaseRequest extends FormRequest
{
    public const INT_32_MAX = 2147483647;
    public const INT_32_MIN = 1;
    public const ORDER_DEFAULT_LENGTH = 100;
    public const WITH_DEFAULT_LENGTH = 100;
    public const PER_PAGE_DEFAULT_MAX = 200;

    /**
     * Common list rules
     *
     * @return array
     */
    public function commonListRules()
    {
        return [
            'page' => [
                'bail',
                'sometimes',
                new PositiveInt32(),
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
            ]
        ];
    }

    /**
     * Common find rule
     *
     * @return array
     */
    protected function commonFindRules()
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

    protected function commonListRulesDynamoDB()
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
            ]
        ];
    }
}
