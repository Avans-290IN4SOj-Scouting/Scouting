<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    public function orderLines(): HasMany
    {
        return $this->hasMany(OrderLine::class);
    }

    public function orderStatus(): HasOne{
        return $this->hasOne(OrderStatus::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function deliveryState(): HasOne{
        return $this->hasOne(DeliveryState::class);
    }
}
