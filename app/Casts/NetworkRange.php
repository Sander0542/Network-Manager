<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use IPv4\SubnetCalculator;

class NetworkRange implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $key
     * @param string $value
     * @param array $attributes
     * @return \IPv4\SubnetCalculator
     */
    public function get($model, string $key, $value, array $attributes)
    {
        $parts = explode('/', $value);

        return new SubnetCalculator($parts[0], $parts[1]);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $key
     * @param \IPv4\SubnetCalculator $value
     * @param array $attributes
     * @return string
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return $value->getNetworkPortion().'/'.$value->getNetworkSize();
    }
}
