<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = Product::query()->paginate(50);
        return $this->sendResponse($products->toArray(), 'Products retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function create(Request $request)
    {

        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $product = Product::query()->create($input);
        return $this->sendResponse($product->toArray(), 'Product created successfully.');
    }*/

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
    public function update(Request $request,$id)
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

    }

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
            $product->delete();
            return $this->sendResponse($product->toArray(), 'Product deleted successfully.');
        }
    }

}
