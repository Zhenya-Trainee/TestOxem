<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $category = Category::query()->paginate(50);
        return $this->sendResponse($category->toArray(), 'Category retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
            'name' => 'required'
        ]);
        $input['id_parent'] = $request->id_parent;
        $input['externalID'] = Str::random(30);
        $input['products'] = $request->products;
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $category= Category::query()->create($input);
        $category->products()->sync($request->products);
        return $this->sendResponse($category->toArray(), 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $category = Category::query()->find($id);
        if (is_null($category)) {
            return $this->sendError('Product not found.');
        } else {
            $input = $request->all();
            $validator = Validator::make($input, [
                'name'=>'required'
            ]);
            $input['products'] = $request->products;

            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $category->name = $input['name'];
            $category->id_parent = $input['id_parent'];
            $category->products()->sync($request->products);
            $category->save();
            return $this->sendResponse($category->toArray(), 'Category updated successfully.');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id){

        $category = Category::query()->find($id);
        if (is_null($category)) {
            return $this->sendError('Category not found.');
        } else {
            DB::delete("DELETE FROM category_product WHERE category_id = {$id}");
            $category->delete();
            return $this->sendResponse($category->toArray(), 'Category deleted successfully.');
        }
    }
}
