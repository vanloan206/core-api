<?php

namespace Mi\Core\Rules;

use Illuminate\Contracts\Validation\Rule;

class Password implements Rule
{
    /**
     * @var string
     */
    protected $regex = '/^(?=.*[0-9])(?=.*[a-zA-Z]).+$/';

    /**
     * @var int
     */
    protected $min = 8;

    /**
     * @var int
     */
    protected $max = 100;

    /**
     * @var string
     */
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
        if (! is_string($value)) {
            $this->message = __('validation.string');
        } elseif ($this->min > strlen($value)) {
            $this->message = __('validation.min.string', ['min' => $this->min]);
        } elseif ($this->max < strlen($value)) {
            $this->message = __('validation.max.string', ['max' => $this->max]);
        } elseif (! preg_match($this->regex, $value)) {
            $this->message = __('validation.custom.password.regex');
        }

        return empty($this->message);
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
        return 'Password';
    }

    /**
     * Set min characters
     *
     * @param int $min
     */
    public function setMin(int $min)
    {
        $this->min = $min;
    }

    /**
     * Set min characters
     *
     * @param int $max
     */
    public function setMax(int $max)
    {
        $this->max = $max;
    }

    /**
     * Set regex
     *
     * @param string $regex
     */
    public function setRegex(string $regex)
    {
        $this->regex = $regex;
    }
}
