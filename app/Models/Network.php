<?php

namespace App\Models;

use App\Casts\NetworkRange;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    use HasFactory;

    protected $casts = [
        'range' => NetworkRange::class,
    ];

    protected $fillable = [
        'user_id',
        'name',
        'range',
    ];

    /**
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public static function whereUser($userId)
    {
        return self::whereNull('user_id')->orWhere('user_id', $userId);
    }

    /**
     * @return string
     */
    public function getRangeStartAttribute(): string
    {
        return $this->range->getMinHost();
    }

    /**
     * @return string
     */
    public function getRangeEndAttribute(): string
    {
        return $this->range->getMaxHost();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ips(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(NetworkIp::class, 'network_id', 'id');
    }

    public function delete()
    {
        // Remove ips on network deletion
        $this->ips()->delete();

        return parent::delete();
    }
}
