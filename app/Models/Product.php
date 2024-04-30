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
    protected $fillable = [
        'name',
        'product_type_id',
        'image_path'
    ];

    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    public function productSizes(): BelongsToMany
    {
        return $this->belongsToMany(ProductSize::class, 'product_product_size', 'product_id', 'product_size_id')
            ->withPivot('price');
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

    public function stock(): HasOne
    {
        return $this->hasOne(Stock::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'product_group');
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setPriceForSize(mixed $priceForSize)
    {
        $this->priceForSize = $priceForSize;
    }

    public function addPriceForSize($sizes, $prices)
    {
        if (!is_array($sizes) || !is_array($prices)) {
            return;
        }
        if (count($sizes) != count($prices)) {
            dd('The number of sizes and prices do not match', $sizes, $prices);
        }
        for ($i = 0; $i < count($sizes); $i++) {
            $this->priceForSize[$sizes[$i]] = $prices[$i];
        }
    }

    public function setGroups($groups)
    {
        if (is_array($groups)) {
            $this->groups = $groups;
        } else {
            $this->groups = [$groups]; // Convert the string to a single-element array
        }
    }

}
