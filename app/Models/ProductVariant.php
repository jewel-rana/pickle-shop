<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductVariant extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'sku', 'price', 'status'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->sku = Str::uuid();
        });
    }
}
