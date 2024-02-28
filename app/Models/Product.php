<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    public function productSize(): BelongsToMany
    {
        return $this->belongsToMany(ProductSize::class)
            ->withPivot('price');
    }
}
