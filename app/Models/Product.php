<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_path',
        'variety_id',
    ];

    public function productTypes(): BelongsToMany
    {
        return $this->belongsToMany(ProductType::class, 'product_product_type', 'product_id', 'product_type_id');
    }

    public function productSizes(): BelongsToMany
    {
        return $this->belongsToMany(ProductSize::class, 'product_product_size', 'product_id', 'product_size_id')
            ->withPivot('price');
    }

    public function variety() : HasOne
    {
        return $this->hasOne(ProductVariety::class, 'variety_id');
    }

    public function size()
    {
        return $this->belongsTo(ProductSize::class, 'product_size_id');
    }

    public function sizes(): BelongsToMany
    {
        return $this->belongsToMany(ProductSize::class)
            ->withPivot('price');
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'product_group');
    }
}
