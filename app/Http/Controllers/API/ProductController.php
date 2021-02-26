<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        switch ($request->s)
        {
            case 1:
                $products = Product::query()->orderBy('price','ASC')->paginate(50);
                return $this->sendResponse($products->toArray(), 'Products retrieved successfully ascending price');
            case 2:
                $products = Product::query()->orderBy('price','DESC')->paginate(50);
                return $this->sendResponse($products->toArray(), 'Products retrieved successfully descending price');
            case 3:
                $products = Product::query()->orderBy('created_at','ASC')->paginate(50);
                return $this->sendResponse($products->toArray(), 'Products retrieved successfully ascending date');
            case 4:
                $products = Product::query()->orderBy('created_at','DESC')->paginate(50);
                return $this->sendResponse($products->toArray(), 'Products retrieved successfully descending date');
            default:
                $products = Product::query()->paginate(50);
                 return $this->sendResponse($products->toArray(), 'Products retrieved successfully.');
        }

    }

    public function getProductCategory(Request $request)
    {
        if ($categories = Category::query()->where('id', $request->id)->first()) {
            $products = DB::query()->select('p.*', 'c.name as category', 'c.id as category_id')
                ->from('categories as c')
                ->join('category_product as cp', 'cp.category_id', '=', 'c.id')
                ->join('products as p', 'cp.product_id', '=', 'p.id')
                ->where('cp.category_id', '=', $request->id)
                ->get();
            if (sizeof($products)) {
                return $this->sendResponse($products->toArray(), 'Products of this category have been successfully received');
            } else {
                return $this->sendError( 'There are no products in this category');
            }
        }
        else {
            return $this->sendError('Category not found');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|max:200',
            'description' => 'required|max:1000',
            'price'=>'required',
            'quantity'=>'required'
        ]);
        $input['externalID'] = Str::random(30);
        $input['categories'] = $request->categories;
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $product = Product::query()->create($input);
        $product->categories()->sync($request->categories);
        return $this->sendResponse($product->toArray(), 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $product = Product::query()->find($id);
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
        return $this->sendResponse($product->toArray(), 'Product retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    /*public function update(Request $request,$id)
    {
        $product = Product::query()->find($id);
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        } else {
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required|max:200',
                'description' => 'required|max:1000',
                'price'=>'required',
                'quantity'=>'required',
                'category_id'=>'required'
            ]);

            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $request->name = $input['name'];
            $request->price = $input['price'];
            $request->description = $input['description'];
            $request->quantity = $input['quantity'];
            $request->category_id = $input['category_id'];
            $request->save();
            return $this->sendResponse($request->toArray(), 'Product updated successfully.');
        }

    }*/

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $product = Product::query()->find($id);
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        } else {
            DB::delete("DELETE FROM category_product WHERE product_id = {$id}");
            $product->delete();
            return $this->sendResponse($product->toArray(), 'Product deleted successfully.');
        }
    }

}
