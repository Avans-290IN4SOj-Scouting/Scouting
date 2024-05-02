<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kyslik\ColumnSortable\Sortable;

class Order extends Model
{
    use HasFactory, Sortable;

    /**
     * The attributes that are sortable.
     *
     * @var array<int, string>
     */
    public $sortable = [
        'id',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_date',
        'lid_name',
        'group_id',
        'user_id',
        'order_status_id',
        'status',
    ];

    protected $fillable = [
        'order_date',
        'lid_name',
        'group_id',
        'status',
    ];

    public function orderLines(): HasMany
    {
        return $this->hasMany(OrderLine::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    function orderStatus(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }
}
