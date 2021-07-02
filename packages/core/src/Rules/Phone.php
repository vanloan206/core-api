<?php

namespace Mi\Core\Rules;

use Illuminate\Contracts\Validation\Rule;

class Phone implements Rule
{
    /** @var string */
    public const REGEX = "/^0[\d]{9,10}$/";

    /** @var int */
    public const MIN = 10;

    /** @var int */
    public const MAX = 11;

    /** @var string */
    protected $message;

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
        switch (true) {
            case (!is_string($value)):
                $this->message = __('validation.string');

                return false;

            case (self::MIN > strlen($value)):
                $this->message = __('validation.min.string', ['min' => self::MIN]);

                return false;

            case (self::MAX < strlen($value)):
                $this->message = __('validation.max.string', ['max' => self::MAX]);

                return false;

            case (!preg_match(self::REGEX, $value)):
                $this->message = __('validation.custom.phone');

                return false;

            default:
                return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }

    public function __toString()
    {
        return 'Phone';
    }
}
