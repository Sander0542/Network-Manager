<?php

namespace App\Rules;

use Dxw\CIDR\IPRange;
use Exception;
use Illuminate\Contracts\Validation\Rule;
use IPv4\SubnetCalculator;

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
        try {
            $parts = explode('/', $value);
            new SubnetCalculator($parts[0], $parts[1]);

            return true;
        } catch (Exception) {
            return false;
        }
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
