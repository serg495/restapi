<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RecipientRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $value === auth()->id();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Only the recipient can confirm/reject the invite';
    }
}
