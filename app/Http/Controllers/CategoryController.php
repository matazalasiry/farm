<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function addcategory(){
        return view('admin.addcategory');
    }
    public function savecategory(Request $request){
        $this->validate($request,['category_name'=>'required']);
    $checkcat =Category::where('category_name',$request->input('category_name'))->first();
    $category =new Category();
    if(!$checkcat){
        $category->category_name = $request->input('category_name');
        $category->save();
        return redirect('/addcategory')->with('status1', 'The '.$category->category_name.' Category has been saved successfully');
    }else {
        return redirect('/addcategory')->with('status2', 'The '.$request->input('category_name').' Category already exist');
    }}
    public function categories(){
    $categories =Category::all();
        return view('admin.categories',compact('categories'));
    }
    public function edit($id){
    $category =Category::find($id);
        return view('admin.editcategory',compact('category'));
    }
    public function updatecategory(Request $request){
        $category =Category::find($request->input('id'));
        $oldcat =$category->category_name;
        $category->category_name = $request->input('category_name');
        $data =array();
        $data['product_category']=$request->input('category_name');
        DB::table('products')
            ->where('product_category',$oldcat)
            ->update($data);
        $category->update();
        return redirect('/categories')->with('status', 'The '.$category->category_name.' Category has been updated successfully');
    }
    public function delete($id){
        $category =Category::find($id);
        $category->delete();
        return redirect('/categories')->with('status', 'The '.$category->category_name.' Category has been deleted successfully');
    }

}
