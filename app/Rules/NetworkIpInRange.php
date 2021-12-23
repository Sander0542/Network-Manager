<?php

namespace App\Rules;

use App\Models\Network;
use Illuminate\Contracts\Validation\Rule;
use IPv4\SubnetCalculator;

class NetworkIpInRange implements Rule
{
    /**
     * @var \IPv4\SubnetCalculator
     */
    private SubnetCalculator $subnet;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(SubnetCalculator $subnet)
    {
        $this->subnet = $subnet;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->subnet->isIPAddressInSubnet($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute doest not fit in the given network range.';
    }
}
