<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Models\Role;

class Group extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_group');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function size(): HasOne {
        return $this->hasOne(ProductSize::class, 'id', 'size_id');
    }

    public function roles(): HasMany {
        return $this->hasMany(Role::class);
    }
}
