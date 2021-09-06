@extends('layouts.appadmin')
@section('title')
    Products
@endsection
@section('content')
    {{Form::hidden('', $increment = 1)}}
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Products</h4>
            @if(Session::has('status'))
                <div class="alert alert-success">
                    {{Session::get('status')}}
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="order-listing" class="table">
                            <thead>
                            <tr>
                                <th>Order</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{$increment}}</td>
                                    <td><img src="/storage/product_image/{{$product->product_image}}" alt=""></td>
                                <td>{{$product->product_name}}</td>
                                <td>${{$product->product_price}}</td>
                                <td>{{$product->product_category}}</td>
                                @if($product->status ==1)
                                            <td>
                                    <label class="badge badge-success">Activated</label>
                                    </td>
                                    @else
                                        <td>
                                            <label class="badge badge-danger">Unactivated</label>
                                        </td>
                                @endif
                                    <td>
                                        <a href="/edit_product/{{$product->id}}" class="btn btn-outlinline-primary">Edit</a>
                                        <a href="/delete_product/{{$product->id}}" class="btn btn-outline-danger" id="delete">Delete</a>
                                        @if($product->status==1)
                                            <a href="/unactive_product/{{$product->id}}" class="btn btn-outline-warning">Unactive</a>
                                        @else
                                            <a href="/active_product/{{$product->id}}"  class="btn btn-outline-success">Activate</a>
                                        @endif
                                    </td>
                                </tr>
                                {{Form::hidden('', $increment = $increment + 1)}}
                            @endforeach

                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
@endsection
@section('scripts')
    <script src="{{asset('backend/js/data-table.js')}}"></script>
@endsection
