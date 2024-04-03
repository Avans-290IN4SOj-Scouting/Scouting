<?php

namespace App\Models;

use App\Models\DeliveryStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Testing\Fluent\Concerns\Has;

class DeliveryState extends Model
{
    use HasFactory;

    public function deliveryStatus(): HasOne{
        return $this->hasOne(DeliveryStatus::class);
    }

    public function order(): BelongsTo{
        return $this->belongsTo(Order::class);
    }
}
