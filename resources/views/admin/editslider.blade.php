@extends('layouts.appadmin')
@section('title')
    Edit Slider
@endsection
@section('content')
    <div class="row grid-margin">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Slider</h4>
                    {!!Form::open(['action'=>'SliderController@updateslider','class'=>'cmxform','method'=>'POST','id'=>'commentForm', 'enctype'=>'multipart/form-data'])!!}
                    {{csrf_field()}}
                    <div class="form-group">
                        {{Form::hidden('id',$slider->id)}}
                        {{Form::label('','Description one',['for'=>'cname'])}}
                        {{Form::text('description_one',$slider->description1,['class'=>'form-control','minlength'=>'2'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('','Description two',['for'=>'cname'])}}
                        {{Form::text('description_two',$slider->description2,['class'=>'form-control','minlength'=>'2'])}}
                    </div>

                    <div class="form-group">
                        {{Form::label('','Slider image')}}
                        {{Form::file('slider_image',['class'=>'form-control'])}}

                    </div>
                    {{Form::submit('Save',['class'=>'btn btn-primary'])}}
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('backend/js/bt-maxLength.js')}}"></script>
@endsection

