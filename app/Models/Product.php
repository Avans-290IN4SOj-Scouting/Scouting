<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    public function productTypes(): BelongsToMany
    {
        return $this->belongsToMany(ProductType::class, 'product_product_type', 'product_id', 'product_type_id');
    }

    public function productSizes(): BelongsToMany
    {
        return $this->belongsToMany(ProductSize::class, 'product_product_size', 'product_id', 'product_size_id')
            ->withPivot('price');
    }

    public function stock(): HasOne
    {
        return $this->hasOne(Stock::class);
    }

    public function productCollection(): BelongsTo
    {
        return $this->belongsTo(ProductCollection::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'product_group');
    }
}
