<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DeliveryStatus extends Model
{
    use HasFactory;

   

    public function deliveryState(): BelongsToMany{
        return $this->belongsToMany(DeliveryState::class);
    }
}
