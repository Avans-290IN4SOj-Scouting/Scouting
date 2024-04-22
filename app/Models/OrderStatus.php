<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderStatus extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'status',
    ];

    protected $enumCasts = [
        'status' => App\Enum\OrderStatus::class
    ];

   public function order(): HasMany{
    return $this->hasMany(Order::class,"","",);
   }
}
