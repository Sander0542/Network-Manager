<?php

namespace App\Rules;

use Exception;
use Illuminate\Contracts\Validation\Rule;
use IPv4\SubnetCalculator;

class NetworkIpsInRange implements Rule
{
    /**
     * @var string[]
     */
    private $ips;

    /**
     * Create a new rule instance.
     *
     * @param string[] $ips
     * @return void
     */
    public function __construct($ips)
    {
        $this->ips = $ips;
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
        try {
            $parts = explode('/', $value);
            $subnet = new SubnetCalculator($parts[0], $parts[1]);

            foreach ($this->ips as $ip) {
                if (!$subnet->isIPAddressInSubnet($ip)) {
                    return false;
                }
            }

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
        return 'The ips do not fit in the range.';
    }
}
