<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MinWords
{
    protected $parameters;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->parameters = $parameters;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */

    public function passes($attribute, $value) {
        $words = explode(' ', $value);
        $nbWords = count($words);
        return ($nbWords >= 100);  // replace 5 by the correct $parameters value
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The attribute must be at least 100 words.';
    }
}
