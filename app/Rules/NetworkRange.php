<?php

namespace App\Rules;

use Dxw\CIDR\IPRange;
use Illuminate\Contracts\Validation\Rule;

class NetworkRange implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !IPRange::Make($value)->isErr();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is not a valid network range.';
    }
}
