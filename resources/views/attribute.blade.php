@extends('app')


@section('content')



<div class="row">
    <div class="col-md-6 mx-auto">
    <br><br>
        <h1>Add Attribute</h1>
        @if(\Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{\Session::get('success')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
        @endif
        <form action="{{route('attribute.store')}}" method="post">
            @csrf
            <div class="mb-3">
                <label for="">Attribute Name:</label>
                <input class="form-control" type="text" name="name">
                @error('name')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <button class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

<br><br><br>

<div>

<h1>View Attribute</h1>
<table class="table table-bordered table-sm">
    <thead>
        <tr>
            <td>ID</td>
            <td>Name</td>
        </tr>
    </thead>
    <tbody>
        @foreach (\App\Models\Attribute::orderBy('id', 'DESC')->get() as $row)
            <tr>
                <td>{{$row->id}}</td>
                <td>{{$row->name}}</td>
            </tr>
        @endforeach
    </tbody>
</table>


</div>




@endsection