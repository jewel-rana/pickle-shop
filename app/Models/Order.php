<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Ramsey\Uuid\DeprecatedUuidMethodsTrait;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id', 'invoice_id', 'total_amount', 'shipping_cost', 'total_payable', 'discount', 'status'];


    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->invoice_id = (string) Str::uuid();
        });
    }
}
