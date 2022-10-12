<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(Auth::user()->id);
        $user = User::with('product')->find(1);
        // $user->product()->detach();
        // dd($user->product()->count());

        // $product_count = $user->product()->count();


        // dd($user->toArray());
        // $user = User::wherePivot('product_id', '=', 2)->detach();
        // $user->product()->detach(1);
        $products = Product::where('status',"1")->get();
        // dd($products);
        return view('frontend.product',compact('products'));
        
        // return view('frontend.product');
    }
    public function my_order()
    {
        $user = User::find(Auth::user()->id)->with('address.order.product')->get();
        // $order = Address::where('user_id',Auth::user()->id)->with('order.product')->get();
        // $order = Address::whereHas();
        // dd($order->address()->select('id'));
        $orders = Order::where('user_id',Auth::user()->id)->with('address','product')->get();

        // dd($orders->toArray());
        return view('frontend.my-order',compact('orders'));
        
    }
    public function cart()
    {
        $user = User::with('product')->find(1);
        $products = $user->product;

        return view('frontend.cart',compact('products'));
    }
    public function add_cart(Request $request)
    {
        $user = User::with('product')->find(Auth::user()->id);
        $num = DB::table('product_user')->where('product_id',$request->id)->where('user_id',Auth::user()->id)->count();

        if($num){
            $arr =[
                'status' => false,
                'duplicate' => "Already added to cart",
            ];
            return response()->json($arr);
        } else {
            $user->product()->attach($request->id);
            $user->product()->count();
            $cart_num = $user->product()->count();
            $arr =[
                'status' => true,
                'cart_number' => $cart_num,
            ];
            return response()->json($arr);
        }


        // dd($user->product()->count());

    }
    public function add_order(Request $request)
    {
        // dd($request->all());    
        $address = new Address;
        $address->address = $request->address;
        $address->user_id =  Auth::user()->id;
        $address->save();

        $order = new Order;
        $order->product_id = $request->prod_id; 
        $order->address_id = $address->id;
        $order->user_id =  Auth::user()->id;
        $order->save();

        $user = User::with('product')->find(Auth::user()->id);
        $user->product()->detach($request->prod_id);
        
        // $user->product()->count();
        $cart_num = $user->product()->count();

        $arr = [
            'status'=> true,
            'message'=> 'ordered sucessfully',
            'cart_count' =>  $cart_num
         ];
        return response()->json($arr);
    }
    public function delete_cart(Request $request)
    {
        $user = User::with('product')->find(Auth::user()->id);
        $user->product()->detach($request->id);
        $user->product()->count();
        $cart_num = $user->product()->count();
        return response()->json($cart_num);
    }

}
