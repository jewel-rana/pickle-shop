<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }

    public function offers(): BelongsToMany
    {
        return $this->belongsToMany(Offer::class)->orderByDesc('offer_end');
    }

    public function activeOffer()
    {
        return $this->offers()->where('offer_start', '<=', now())->where('offer_end', '>', now())->first();
    }

    public function productVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class, 'product_id', 'id');
    }

    public function stock()
    {
        return $this->stocks()->sum('qty');
    }
}
