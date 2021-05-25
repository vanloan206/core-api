<?php

namespace Mi\Core\Rules;

use Illuminate\Contracts\Validation\Rule;

class Price implements Rule
{
    const MIN = 0;
    const MAX = 99999999;

    /**
     * @var int $min
     */
    protected $min;

    /**
     * @var int $max
     */
    protected $max;

    /**
     * New instance of Price
     *
     * @param int $min
     * @param int $max
     */
    public function __construct($min = self::MIN, $max = self::MAX)
    {
        $this->min = $min;
        $this->max = $max;
    }

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
        if (! is_numeric($value)) {
            return false;
        }

        $v = (int)$value;

        return  $this->min <= $v && $v <= $this->max;
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
            'max' => $this->max
        ]);
    }

    public function __toString()
    {
        return 'Price';
    }
}
