<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

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
