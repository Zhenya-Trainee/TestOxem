<?php

namespace App\Http\Controllers\Api;


use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

class SortingController extends BaseController
{
    public function sorting(Request $request)
    {
        switch ($request->s)
        {
            case 1:
                $products = Product::query()->orderBy('price','DESC')->paginate(50);;
                return $this->sendResponse($products->toArray(), 'Products retrieved successfully');
            case 2:
                $products = Product::query()->orderBy('price','ASC')->paginate(50);;
                return $this->sendResponse($products->toArray(), 'Products retrieved successfully');
            case 3:
                $products = Product::query()->orderBy('created_at','ASC')->paginate(50);;
                return $this->sendResponse($products->toArray(), 'Products retrieved successfully');
            case 4:
                $products = Product::query()->orderBy('created_at','DESC')->paginate(50);;
                return $this->sendResponse($products->toArray(), 'Products retrieved successfully');
        }
    }
}

