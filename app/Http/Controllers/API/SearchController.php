<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends BaseController
{
    public function getProductCategory(Request $request)
    {
        $products = Product::query()->where('category_id','=',$request->category_id)->paginate(50);
        return $this->sendResponse($products->toArray(), 'Products retrieved successfully');
    }
}
