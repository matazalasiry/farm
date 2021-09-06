<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Slider;
use App\Models\client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use MongoDB\Driver\Session;
use Stripe\Charge;
use Stripe\Stripe;

class ClientController extends Controller
{
    public function home(){
        $products =Product::where('status',1)->get();
        $sliders =Slider::where('status',1)->get();
        return view('client.home',compact('sliders','products'));
    }
    public function cart(){

        if(!session()->has('cart')){
            return view('client.cart');
        }
        $oldCart =Session()->has('cart')?Session()->get('cart'):null;
        $cart =new Cart($oldCart);
        $products = $cart->items;
        return view('client.cart',compact('products'));
    }
    public function addToCart($id){
        $product =Product::find($id);
        $oldCart = Session()->has('cart')? Session()->get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->add($product, $id);
        Session()->put('cart', $cart);
//        dd(Session()->get('cart'));
        return redirect('/shop');
    }
    public function updateQty(Request $request){
        //print('the product id is '.$request->id.' And the product qty is '.$request->quantity);
        $oldCart = Session()->has('cart')? Session()->get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->updateQty($request->id, $request->quantity);
        Session()->put('cart', $cart);

        //dd(Session::get('cart'));
        return redirect()->to('/cart');
    }
    public function removeItem($product_id){
        $oldCart = Session()->has('cart')? Session()->get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->removeItem($product_id);

        if(count($cart->items) > 0){
            Session()->put('cart', $cart);
        }
        else{
            Session()->forget('cart');
        }
        //dd(Session::get('cart'));
        return redirect('/cart');
    }
    public function shop(){
        $categories = Category::all();
        $products =Product::where('status',1)->get();
        return view('client.shop',compact('products','categories'));
    }
    public function view_by_cat($name){
        $categories = Category::all();
        $products =Product::where('product_category',$name)->get();
        return view('client.shop',compact('categories','products'));


    }
    public function checkout(){
        if (!session()->has('client')) {
            return redirect('/client_login');
        }
        if(!session()->has('cart')){
        return redirect('/cart');
        }
        return view('client.checkout');
    }
    public function postcheckout(Request $request){
        {

            if (!session()->has('cart')) {
                return redirect('/cart');
            }
            $oldCart = Session()->has('cart') ? Session()->get('cart') : null;
            $cart = new Cart($oldCart);
            $stripe_obj = new Stripe();
            $stripe = $stripe_obj->setApiKey(env('STRIPE_SECRET'));
            $charge = Charge::create([
                "amount" => $cart->totalPrice * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "This payment is tested purpose phpcodingstuff.com"
            ]);
            $order = new Order();
            $order->name = $request->input('name');
            $order->address = $request->input('address');
            $order->cart = serialize($cart);
            $order->payment_id = $charge->id;
            $order->save();
            $orders = Order::where('payment_id', $charge->id)->get();
            $orders->transform(function($order){
                $order->cart =unserialize($order->cart);
                return $order;
            });
            $email =Session()->get('client')->email;
            Mail::to($email)->send(new SendMail($orders));

            Session()->forget('cart');
            return redirect('/cart')->with('success', 'purchase accomplished successfully !');
        }
    }
    public function login(){
        return view('client.login');
    }
    public function signup(){
        return view('client.signup');
    }
    public function createaccount(Request $request){
    $client = new Client();
    $client->email = $request->input('email');
    $client->password =bcrypt($request->input('password'));
    $client->save();
    return back()->with('status','Your account has been created successfully');
    }

public function accessaccount(Request $request){
    $client =Client::where('email',$request->input('email'))->first();
    if($client) {
    if (Hash::check($request->input('password') , $client->password)){
        Session()->put('client',$client);
        return redirect('/shop');
    }else{
       return back()->with('status','Wrong password or email');
    }
    }else{
        return back()->with('status','You do not have an account');
    }
    }
    public function logout(){
        Session()->forget('client');
        return back();
    }
}
