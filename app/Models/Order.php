<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
      'rewardParams' => 'array'
    ];

    public function coupon()
    {
        return $this->hasOne(OrderCoupon::class);
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function logs()
    {
        return $this->hasMany(OrderLog::class, 'orderCode', 'orderCode');
    }

    public function internalLogs()
    {
        return $this->hasMany(OrderInternalLog::class, 'orderCode', 'orderCode');
    }
}
