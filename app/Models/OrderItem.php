<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['order_id', 'product_id', 'product_variant_id', 'qty', 'unit_price', 'discount', 'total_price'];
}
