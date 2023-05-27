@extends('app')


@section('content')



<div class="row">
    <div class="col-md-6 mx-auto">
    <br><br>
        <h1>Add Attribute Value</h1>
        @if(\Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{\Session::get('success')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
        @endif
        <form action="{{route('variant.store')}}" method="post">
            @csrf
            <div class="mb-3">
                <label for="">Attribute Name:</label>
                <select class="form-control" name="attribute_id" id="">
                    <option value="">Select Attribute Name</option>
                    @foreach (\App\Models\Attribute::orderBy('id', 'DESC')->get() as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </select>
                @error('attribute_id')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="">Attribute Value:</label>
                <input class="form-control" type="text" name="value">
                @error('value')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <button class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

<br><br><br>

<div>

<h1>View Attribute Values</h1>
<table class="table table-bordered table-sm">
    <thead>
        <tr>
            <td>ID</td>
            <td>Name</td>
            <td>Values</td>
        </tr>
    </thead>
    <tbody>
        @foreach (\App\Models\Attribute::orderBy('id', 'DESC')->get() as $row)
            <tr>
                <td>{{$row->id}}</td>
                <td>{{$row->name}}</td>
                <td>
                    @foreach ($row->variants as $variant)
                    <span class="badge badge-dark">{{strtoupper($variant->value)}}</span>
                    @endforeach
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


</div>




@endsection