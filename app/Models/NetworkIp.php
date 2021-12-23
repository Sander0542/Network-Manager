<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetworkIp extends Model
{
    use HasFactory;

    protected $casts = [
        'ports' => 'array',
    ];

    protected $fillable = [
        'network_id',
        'name',
        'address',
        'ports',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function network(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Network::class, 'id', 'network_id');
    }
}
