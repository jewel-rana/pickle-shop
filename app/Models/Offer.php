<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Offer extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'min_order', 'amount', 'discount_type', 'offer_start', 'offer_end'];
    protected $guarded = ['product_ids'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
