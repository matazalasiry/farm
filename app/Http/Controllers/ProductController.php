<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use MongoDB\Driver\Session;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function addproduct(){
        $categories =Category::all()->pluck('category_name','category_name');
        return view('admin.addproduct',compact('categories'));
    }
    public function saveproduct(Request $request){
        $this->validate($request,['product_name'=>'required',
                                  'product_price'=>'required',
                                  'product_image'=>'image|nullable|max:1999']);
if($request->input('product_category')){
    if($request->hasFile('product_image')){
        $fileNameWithExt =$request->file('product_image')->getClientOriginalName();
        $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        $extension =$request->file('product_image')->getClientOriginalExtension();
        $fileNameToStore = $filename .'_'. time(). '.'. $extension;
        $path = $request->file('product_image')->storeAs('public/product_image', $fileNameToStore);




    }else{
        $fileNameToStore = 'noimage.jpg';
    }
    $product = new Product();
    $product->product_name =$request->input('product_name');
    $product->product_price = $request->input('product_price');
    $product->product_category = $request->input('product_category');
    $product->product_image =$fileNameToStore ;
    $product->status = 1;

    $product->save();
    return redirect('/addproduct')->with('status1', 'The '.$product->product_name.' Product has been saved successfully');
}
else{
    return redirect('/addproduct')->with('status2', 'Select the category please');
}
    }
    public function products(){
        $products = Product::all();
    return view('admin.products',compact('products'));
    }
    public function editproduct($id){
        $categories =Category::all()->pluck('category_name','category_name');
        $product = Product::find($id);
    return view('admin.editproduct',compact('product','categories'));
    }

    public function updateproduct(Request $request){
        $this->validate($request,['product_name'=>'required',
                                  'product_price'=>'required',
                                  'product_image'=>'image|nullable|max:1999']);
        $product =Product::find($request->input('id'));
        $product->product_name =$request->input('product_name');
        $product->product_price = $request->input('product_price');
        $product->product_category = $request->input('product_category');
    if($request->hasFile('product_image')) {
        $fileNameWithExt = $request->file('product_image')->getClientOriginalName();
        $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('product_image')->getClientOriginalExtension();
        $fileNameToStore = $filename . '_' . time() . '.' . $extension;
        $path = $request->file('product_image')->storeAs('public/product_image', $fileNameToStore);
       // $old_image =Product::find($request->input('id'));
        if( $product->product_image != 'noimage.jpg'){
            Storage::delete('public/product_image/'.$product->product_image);

        }
        $product->product_image =$fileNameToStore ;

    }
        $product->update();
        return redirect('/products')->with('status', 'The '.$product->product_name.' Product has been updated successfully');


    }
    public function delete_product($id)
    {
        $product = Product::find($id);

              if ($product->product_image != 'noimage.jpg') {
                Storage::delete('public/product_image/'.$product->product_image);
       }
       $product->delete();
       return redirect('/products')->with('status', 'The '.$product->product_name.' Product has been deleted successfully');
    }
    public function active($id){
        $product = Product::find($id);
        $product->status = 1;
        $product->update();
        return redirect('/products')->with('status', 'The '.$product->product_name.' Product has been activated successfully');

    }
    public function unactive($id){
        $product = Product::find($id);
        $product->status = 0;
        $product->update();
        return redirect('/products')->with('status', 'The '.$product->product_name.' Product has been unactivated successfully');
    }





}

