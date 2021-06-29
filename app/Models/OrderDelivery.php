<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDelivery extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'delivery_man_name', 'delivery_man_mobile', 'cash_received', 'cash_returned', 'status'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
