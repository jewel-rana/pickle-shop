<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id', 'total_amount', 'shipping_cost', 'total_payable', 'discount', 'status'];

    public function orderItems(): HasMany
    {
        return $this->hasMany(Order::class, 'id', 'order_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
}
