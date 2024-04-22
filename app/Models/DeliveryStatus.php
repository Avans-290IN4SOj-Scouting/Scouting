<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DeliveryStatus extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'status',
    ];

    protected $enumCasts = [
        'status' => App\Enum\DeliveryStatus::class,
    ];

   

    public function deliveryState(): BelongsToMany{
        return $this->belongsToMany(DeliveryState::class);
    }
}
