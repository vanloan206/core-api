<?php

namespace Mi\Core\Rules;

use Illuminate\Contracts\Validation\Rule;

class PositiveInt32 implements Rule
{
    public const MIN = 0;
    public const MAX = 2147483648;

    /** @var array */
    protected $includes;

    /**
     * New instance of PositiveInt32
     *
     * @param array $includes
     */
    public function __construct($includes = [])
    {
        $this->includes = $includes;
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

        return (self::MIN < $v && $v < self::MAX) || in_array($v, $this->includes);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.between.numeric', [
            'min' => self::MIN,
            'max' => self::MAX
        ]);
    }

    public function __toString()
    {
        return 'PositiveInt32';
    }
}
