<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends BaseController
{
    public function getProductCategory(Request $request)
    {
        if ($categories = Category::query()->where('id', $request->id)->first())
        {
            $products = $categories->products()->with('categories')->paginate(50);
            return $this->sendResponse($products->toArray(), 'Products found successfully');
        } else{
            return $this->sendError('Category not found');
        }
    }
}
