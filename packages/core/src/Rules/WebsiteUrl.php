<?php

namespace Mi\Core\Rules;

use Illuminate\Contracts\Validation\Rule;

class WebsiteUrl implements Rule
{
    const WEBSITE_URL_REGEX = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w\.-]*)*\/?/';
    const MAX = 255;

    /**
     * @var int
     */
    protected $max;

    /**
     * @var string
     */
    protected $message;

    /**
     * New instance of WebsiteUrl
     *
     * @param int $max
     */
    public function __construct($max = self::MAX)
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
        switch (true) {
            case (! is_string($value)):
                $this->message = __('validation.string');

                return false;

            case ($this->max < strlen($value)):
                $this->message = __('validation.max.string', ['max' => $this->max]);

                return false;

            case (! preg_match(self::WEBSITE_URL_REGEX, $value)):
                $this->message = __('validation.custom.url.regex');

                return false;

            default:
                return true;
        }
    }

    /**
     * Get the validation error message
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }

    public function __toString()
    {
        return 'WebsiteUrl';
    }
}
