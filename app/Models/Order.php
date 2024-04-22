<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'order_date', 'email', 'lid_name', 'order_status_id', 'user_id', 'group_id'];

    public function getRouteKeyName(){
        return "id";
    }

    public function orderLine(): HasMany
    {
        return $this->hasMany(OrderLine::class);
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function orderStatus(): BelongsTo{
        return $this->belongsTo(OrderStatus::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function deliveryState(): HasOne{
        return $this->hasOne(DeliveryState::class);
    }

    public function getMostExpensiveOrderLine()
    {
       $orderLines = $this->orderLine;
       
       $highestAmount = 0;
       $mostExpensiveOrderLine = null;


       foreach($orderLines as $orderLine){
        if($orderLine->amount > $highestAmount){
            $mostExpensiveOrderLine = $orderLine;
            $highestAmount = $orderLine->amount;
       }

       return $mostExpensiveOrderLine;
    }

        
    }
}
