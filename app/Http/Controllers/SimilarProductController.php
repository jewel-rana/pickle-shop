<?php

namespace App\Http\Controllers;

use App\Constants\AppConstant;
use App\Models\Product;
use Illuminate\Http\Request;

class SimilarProductController extends Controller
{
    public function similarProducts(Request $request, $id)
    {
        $product = Product::with(['similarProducts' => function ($query) use ($request)
            {
                $query->with(['productVariants.attributes', 'productVariants.stock' => function ($q)
                {
                    $q->where('qty', '>=', AppConstant::MIN_STOCK_AMOUNT);
                }]);
                if ($request->has('price'))
                {
                    $query->whereHas('productVariants', function ($q) use ($request) {
                        $q->where('price', '=', $request->price);
                    });
                }
            }
            ])->findOrFail($id);

        return response()->success(null, $product->similarProducts);
    }
}
