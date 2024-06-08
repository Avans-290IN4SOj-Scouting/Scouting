<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductVariety extends Model
{
    protected $fillable = ['variety'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
