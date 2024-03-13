<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $fillable = ['name', 'discount', 'product_type_id', 'image_path', 'size'];

    use HasFactory;

    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    public function productSizes(): BelongsToMany
    {
        return $this->belongsToMany(ProductSize::class)
            ->withPivot('price');
    }

    public function stock(): HasOne
    {
        return $this->hasOne(Stock::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'product_group');
    }
}
