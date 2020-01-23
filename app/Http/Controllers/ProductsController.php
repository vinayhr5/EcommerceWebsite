<?php

namespace App\Http\Controllers;
use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use App\Mail\OrderCreatedEmail;
use Illuminate\Support\Facades\Mail;

class ProductsController extends Controller
{
    //
    public function index() {
        /* $products = [0=> ["name"=>"Iphone", "category" => "smartphone","price"=>1000],
            1=> ["name"=>"Galaxy", "category" => "tablets","price"=>2000],
            2=> ["name"=>"Sony", "category" => "TV","price"=>3000]
            ]; */
        $products = Product::all();

        return view("allproducts",compact("products"));
    }

    public function addProductToCart(Request $request, $id){
        $prevCart = $request->session()->get('cart');
        $cart = new Cart($prevCart);

        $product = Product::find($id);
        $cart->addItem($id,$product);
        $request->session()->put('cart', $cart);

//        dump($cart);
        return redirect()->route(("allProducts"));

    }
    public function showCart(){
        $cart = Session::get('cart');

        //cart is not empty
        if ($cart) {
//            dump($cart);
            return View('cartproducts',['cartItems'=>$cart]);
            //cart is empty
        }else{
//            echo "empty";
            return redirect()->route("allProducts");
        }
    }
}
