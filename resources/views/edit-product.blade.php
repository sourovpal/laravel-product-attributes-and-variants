@extends('app')


@section('content')



<div class="row">
    <div class="col-lg-6 mx-auto">
        <br><br>
            <h1>Product</h1>
            @if(\Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{\Session::get('success')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
            @endif
            <form action="{{route('product.update', $product->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="">Products Title:</label>
                    <input class="form-control" type="text" name="title" value="{{$product->title}}">
                    @error('title')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="">Descripton:</label>
                    <input class="form-control" type="text" name="description" value="{{$product->description}}">
                    @error('description')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="">Price:</label>
                    <input class="form-control" type="text" name="price" value="{{$product->price}}">
                    @error('price')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="">Image:</label>
                    <input class="form-control" type="file" name="image">
                    @error('image')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                    <br>
                    <div>
                        <img class="img-thumbnail w-25" src="{{asset('/upload/'.$product->image)}}" alt="">
                    </div>
                    <br>
                </div>
                <br>
                <div>
                    <button class="btn btn-primary">Submit</button>
                </div>
                <br>
        </div>
        <div class="col-lg-6">
            <br><br>
                <h1>Product Variants</h1>
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <td width="5%">ID</td>
                            <td width="5%">Image</td>
                            <td width="25%">Attr String</td>
                            <td width="5%">Price</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (\App\Models\ProductVariant::where('product_id', $product->id)->orderBy('id', 'DESC')->get() as $row)
                            <tr>
                                <td>{{$row->id}}</td>
                                <td><img class="img-thumbnail" src="{{asset('/upload/'.$row->image)}}" alt=""></td>
                                <td>{{$row->variants_string}}</td>
                                <td>${{$row->price}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            <br><br>
        </div>
        <div class="col-lg-8">
            <div class="mb-3 d-flex">
                <ul class="list-unstyled">
                    @foreach ($attributeValues as $key => $attrs)
                        <li class="d-flex mb-1">
                            @foreach ($attrs as $attr)
                                <input name="product_variants[{{$key}}][variants][]" class="w-25 form-control mr-1" value="{{$attr}}" readonly>
                            @endforeach
                            <input name="product_variants[{{$key}}][price]" type="text" class="w-25 form-control mr-1" placeholder="Price" value="">
                            <input name="product_image[{{$key}}]" type="file" class="w-50 form-control mr-1" placeholder="Image" value="">
                        </li> 
                    @endforeach
                </ul>
            </div>
        </div>
        </form>
    </div>
</div>


@endsection