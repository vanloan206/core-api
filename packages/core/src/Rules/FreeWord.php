<?php

namespace Mi\Core\Rules;

use Illuminate\Contracts\Validation\Rule;

class FreeWord implements Rule
{
    public const MIN_INT = 1;
    public const MAX_INT_2 = 32767;
    public const MAX_INT_4 = 2147483647;

    /** @var int $min */
    protected $min = self::MIN_INT;

    /** @var int $max */
    protected $max = self::MAX_INT_2;

    public function setMin(int $min)
    {
        $this->min = $min;
    }

    public function setMax(int $max)
    {
        $this->max = $max;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function passes($attribute, $value)
    {
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.between.numeric', [
            'min' => $this->min,
            'max' => $this->max,
        ]);
    }

    public function __toString()
    {
        return 'FreeWord';
    }
}
