<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class ProductVariant extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'sku', 'price', 'status'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function stock(): HasOne
    {
        return $this->hasOne(Stock::class, 'product_variant_id', 'id');
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(ProductVariantAttribute::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->sku = Str::uuid();
        });
    }
}
