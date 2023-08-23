<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    //return pizza list
    public function pizzaList(Request $request){
        logger($request->status);
        if($request->status == 'desc'){
            $data = Product::orderBy('created_at','desc')->get();

        }else{
            $data = Product::orderBy('created_at','asc')->get();
        }
        return $data;
    }

    //add to cart
    public function addToCart(Request $request){

        $data = $this->getOrderData($request);
        Cart::create($data);
        $response = [
            'status' => 'success',
            'message' => 'Add to Cart Complete'
        ];
        return response()->json($response,200);
    }
    //order
    public function order(Request $request){

        $total =0;
        foreach($request->all() as $item){

            $data = OrderList::create($item);
            $total +=$data->total;

        }

        Cart::where('user_id',Auth::user()->id)->delete();
        Order::create([
            'user_id' => Auth::user()->id,
            'order_code' => $data->order_code,
            'total_price' => $total+3000
        ]);
        // Order::create([
        //     'user_id' => Auth::user()->id,
        //     'orderCode' => $request
        // ])
        return response()->json([
            'status' => 'true',
            'message' => 'order complete'
        ],200);
    }
    //clear cart
    public function clearCart(){
        Cart::where('user_id',Auth::user()->id)->delete();
        return response()->json();
    }
    //clear current product
    public function clearCurrentProduct(Request $request){
        // logger($request->all());
        Cart::where('user_id',Auth::user()->id)->where('id',$request->orderId)->where('product_id',$request->productId)->delete();
    }
    //increase view count
    public function increaseViewCount(Request $request){
        $pizza = Product::where('id',$request->productId)->first();
        Product::where('id',$request->productId)->update(['view_count' => $pizza->view_count +1]);
    }
    //change user role
    public function changeUserRole(Request $request){

        $data['role'] = $request->role;

        User::where('id',$request->userId)->update($data);
       return response()->json();
    }
    //get Order Data
    private function getOrderData($request){
        return[
            'user_id' => $request->userId,
            'product_id' => $request->pizzaId,
            'qty' => $request->count,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }
}
