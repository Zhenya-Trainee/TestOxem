<?php

namespace App\Http\Controllers\TestConsole;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

class TestCategories extends BaseController
{
   public function index()
   {
       $j = file_get_contents(__DIR__ . '/categories.json');
       $json_array = json_decode($j, true);
       $assoc_array = array();

       for($i = 0; $i < sizeof($json_array); $i++)
       {
           $input['name'] = $json_array[$i]['name'];
           $input['externalID'] = $json_array[$i]['external_id'];
           $product = Category::query()->create($input);
       }
       $success = true;
       return $this->sendResponse($success, 'Category created successfully.');
   }
}
