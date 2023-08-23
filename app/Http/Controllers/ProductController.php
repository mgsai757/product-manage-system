<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;




class ProductController extends Controller
{
    //product list
    public function list(){
        $pizzas = Product::select('products.*','categories.name as category_name')
        ->when(request('key'),function($query){
            $query->where('products.name','like','%'.request('key').'%');
        })
        ->leftJoin('categories','products.category_id','categories.id')
        ->orderBy('products.created_at','desc')
        ->paginate(3);
        // dd($pizzas->toArray());
        $pizzas->appends(request()->all());
        return view('admin.product.pizzaList',compact('pizzas'));
    }
    //direct pizza create page
    public function createPage(){
        $categories = Category::select('id','name')->get();
        // dd($categories->toArray());
        return view('admin.product.create',compact('categories'));
    }
    //create pizza
    public function create(Request $request){
        // dd($request->all());
        $this->productValidationCheck($request,"create");
        $data = $this->requestProductInfo($request);
        if($request->hasFile('pizzaImage')){
            $fileName = uniqid() . $request->file('pizzaImage')->getClientOriginalName();
            $request->file('pizzaImage')->storeAs('public',$fileName);
            $data['image'] = $fileName;

        }
        Product::create($data);
        return redirect()->route('product#list');
    }
    //edit pizza
    public function edit($id){
        $pizza = Product::select('products.*','categories.name as category_name')
        ->leftJoin('categories','products.category_id','categories.id')
        ->where('products.id',$id)->first();
        return view('admin.product.edit',compact('pizza'));
    }
    //delete pizza
    public function delete($id){

        Product::where('id',$id)->delete();
        return redirect()->route('product#list')->with(['deleteSuccess' => 'Product Delete Success']);
    }
    //pizza update page
    public function updatePage($id){
        $pizza =Product::where('id',$id)->first();
        $category =Category::get();
        // dd($category->toArray());
        return view('admin.product.update',compact('pizza','category'));
    }
    //update pizza
    public function update(Request $request){
        // dd($request->all());
        $this->productValidationCheck($request,"update");
        $updateData = $this->requestProductInfo($request);

        // dd('success');
        if($request->hasFile('pizzaImage')){
            $oldImageName =Product::where('id',$request->pizzaId)->first();
            $oldImageName =$oldImageName->image;
            if($oldImageName !=null){
                Storage::delete('public/'.$oldImageName);
            }
            $fileName = uniqid(). $request->file('pizzaImage')->getClientOriginalName();
            $request->file('pizzaImage')->storeAs('public',$fileName);
            $updateData['image'] = $fileName;
        }
        // dd($updateData);
        Product::where('id',$request->pizzaId)->update($updateData);
        return redirect()->route('product#list');

    }

    //request product info
    private function requestProductInfo($request){
        return[
            'category_id' => $request->pizzaCategory,
            'name' => $request->pizzaName,
            'description' => $request->pizzaDescription,
            'price' => $request->pizzaPrice,
            'waiting_time' => $request->pizzaWaitingTime
        ];
    }
    //product validation check
    private function productValidationCheck($request,$action){
        $validationRules =[
            'pizzaName' => 'required |min:5 |unique:products,name,'.$request->pizzaId,
            'pizzaCategory' => 'required',
            'pizzaDescription' => 'required | min:10',
            'pizzaPrice' => 'required',
            'pizzaWaitingTime' => 'required'
        ];
        $validationRules['pizzaImage'] = $action == "create"? 'required | mimes:jpg,jpeg,png,webp|file': 'mimes:jpg,jpeg,png,webp|file';

        Validator::make($request->all(),$validationRules)->validate();
    }
}
