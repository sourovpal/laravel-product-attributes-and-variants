@extends('app')


@section('content')



<div class="row">
    <div class="col-md-8 mx-auto">
    <br><br>
        <h1>Add Products</h1>
        @if(\Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{\Session::get('success')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
        @endif
        <form action="{{route('product.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="">Products Title:</label>
                <input class="form-control" type="text" name="title">
                @error('title')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="">Descripton:</label>
                <input class="form-control" type="text" name="description">
                @error('description')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="">Price:</label>
                <input class="form-control" type="text" name="price">
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
            </div>
            
            <div class="mb-3 d-flex">
                @foreach (\App\Models\Attribute::orderBy('id', 'DESC')->get() as $row)
                    <label class="d-flex mr-3">
                        <input name="attributes[]" type="checkbox" class="mr-1" value="{{$row->id}}">
                        <span>{{ucfirst($row->name)}}</span>
                    </label>
                @endforeach
            </div>

            <button class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

<br><br><br>

<div>

<h1>View Products</h1>
<table class="table table-bordered table-sm">
    <thead>
        <tr>
            <td width="5%">ID</td>
            <td width="10%">Image</td>
            <td>Name</td>
            <td width="5%">Price</td>
            <td width="25%">Attributes</td>
            <td width="10%">Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach (\App\Models\Product::orderBy('id', 'DESC')->get() as $row)
            <tr>
                <td>{{$row->id}}</td>
                <td><img class="img-thumbnail" src="{{asset('/upload/'.$row->image)}}" alt=""></td>
                <td>{{$row->title}}</td>
                <td>${{$row->price}}</td>
                <td>
                    @foreach (\App\Models\ProductAttribute::where('product_id', $row->id)->get() as $attribute)
                        <span class="badge badge-dark">{{strtoupper($attribute->attribute_name)}}</span>                       
                    @endforeach
                </td>
                <td>
                    <a class="btn btn-warning" href="{{route('product.edit', $row->id)}}">Edit</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<br><br><br><br>

</div>




@endsection