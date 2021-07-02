<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SimilarProductController extends Controller
{
    public function similarProducts(Request $request, $id)
    {
        return Product::with(['productVariants.stck', 'similarProducts.productVariants.stock' => function($query) use($request){
            if($request->has('price')) {
                $query->whereHas('productVariants', function($q) use($request) {
                    $q->where('price', '=', $request->price);
                });
            }
            }])-findOrFail($id);
    }
}
