<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function addslider()
    {
        return view('admin.addslider');
    }

    public function saveslider(Request $request)
    {
        $this->validate($request, [ 'description_one' => 'required',
                                    'description_two' => 'required',
                                    'slider_image' => 'image|nullable|max:1999']);

        if ($request->hasFile('slider_image')) {
            $fileNameWithExt = $request->file('slider_image')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('slider_image')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $path = $request->file('slider_image')->storeAs('public/slider_image', $fileNameToStore);


        } else {
            $fileNameToStore = 'noimage.jpg';
        }
        $slider = new Slider();
        $slider->description1 = $request->input('description_one');
        $slider->description2 = $request->input('description_two');
        $slider->slider_image = $fileNameToStore;
        $slider->status = 1;

        $slider->save();
        return redirect('/addslider')->with('status1', 'The Slider has been saved successfully');
    }

    public function sliders()
    {
        $sliders = Slider::all();

        return view('admin.sliders', compact('sliders'));
    }

    public function editslider($id)
    {
        $slider = Slider::find($id);
        return view('admin.editslider', compact('slider'));
    }

    public function updateslider(Request $request)
    {
        $this->validate($request, [ 'description_one' => 'required',
                                    'description_two' => 'required',
                                    'slider_image' => 'image|nullable|max:1999']);

        $slider = Slider::find($request->input('id'));
        $slider->description1 = $request->input('description_one');
        $slider->description2 = $request->input('description_two');
        if ($request->hasFile('slider_image')) {
            $fileNameWithExt = $request->file('slider_image')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('slider_image')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $path = $request->file('slider_image')->storeAs('public/slider_image', $fileNameToStore);
            if ($slider->slider_image != 'noimage.jpg') {
                Storage::delete('public/slider_image/' . $slider->slider_image);
            }
            $slider->slider_image = $fileNameToStore;
        }
            $slider->update();
             return redirect('/sliders')->with('status1', 'The Slider has been updated successfully');

    }

public function delete_slider($id){

    $slider = Slider::find($id);

    if ($slider->slider_image != 'noimage.jpg') {
        Storage::delete('public/slider_image/'.$slider->slider_image);
    }
    $slider->delete();
    return redirect('/sliders')->with('status1', 'The '.$slider->slider_name.' Slider has been deleted successfully');
}
    public function active($id){
        $slider = Slider::find($id);
        $slider->status = 1;
        $slider->update();
        return redirect('/sliders')->with('status', 'The '.$slider->slider_name.' Slider has been activated successfully');

    }
    public function unactive($id){
        $slider = Slider::find($id);
        $slider->status = 0;
        $slider->update();
        return redirect('/sliders')->with('status', 'The '.$slider->slider_name.' Slider has been unactivated successfully');


    }
}
