@extends('app')


@section("content")

<div class="row">
    @foreach (\App\Models\Product::orderBy('id', 'DESC')->get() as $product)
        <div class="col-lg-3">
            <div class="card">
                <img src="{{asset('/upload/'.$product->image)}}" class="card-img-top" alt="..." style="height:250px;">
                <div class="card-body">
                    <h5 class="card-title">{{$product->title}}</h5>
                    <p class="card-text">{{$product->description}}</p>
                    <div>
                        <a href="{{route('product.details', $product->id)}}" class="btn btn-primary">Details</a>
                        <span class="ml-5 font-weight-bold">${{$product->price}}</span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>



@endsection