<?php

namespace App\Http\Controllers\api;

use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RouteController extends Controller
{
    //category list
    public function categoryList(){
        $category = Category::get();
        return response()->json($category,200);
    }
    //create category
    public function categoryCreate(Request $request){
        $data = [
            'name' => $request->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
        $response = Category::create($data);
        return response()->json($response,200);
    }
    //delete category
    public function categoryDelete(Request $request){
        $data =Category::where('id',$request->category_id)->first();
        if(isset($data)){
            Category::where('id',$request->category_id)->delete();
            return response()->json(['status' =>'true', 'message' => 'delete success'],200);
        }
        return response()->json(['status' =>'false' , 'message' => 'There is no category ...'],200);
    }
}
