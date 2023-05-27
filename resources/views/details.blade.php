@extends('app')


@section("content")
<style>
.attribute_action,
.attribute_action ~ span{
    cursor: pointer;
}
</style>
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <img id="product_img" src="{{asset('/upload/'.$product->image)}}" class="card-img-top" alt="..." style="height:250px;">
            <div class="card-body">
                <h5 class="card-title">{{$product->title}}</h5>
                <p class="card-text">{{$product->description}}</p>
                <p id="product_price" class="font-weight-bold">${{$product->price}}</p>
                <input id="product_id" type="hidden" value="{{$product->id}}">
            </div>
        </div>
    </div>
    <div class="col-lg-8">

        @php
            $proAttr = \App\Models\ProductAttribute::where('product_id', $product->id)->pluck('attribute_id');
        @endphp

        @foreach (\App\Models\Attribute::whereIn('id', $proAttr)->get() as $attribute)
            <h3>{{ucfirst($attribute->name)}}</h3>
            <div class="d-flex">
                @foreach ($attribute->variants as $value)
                    <label class="d-flex mr-3">
                        <input class="attribute_action mr-1" name="{{$attribute->name}}" type="radio" value="{{$value->value}}">
                        <span>{{ucfirst($value->value)}}</span>
                    </label>
                @endforeach
            </div>
        @endforeach

    </div>
</div>




<script>



$('.attribute_action').click(function(){
    var variants = [];
    $('.attribute_action:checked').each(function(i){
        variants.push($(this).val());
    });
    var data = {
        product_id:$('#product_id').val(),
        variants,
    }

     $.ajax({
            type: "GET",
            url:"{{route('product.details', $product->id)}}",
            data:data,
            success: function (res) {
                console.log(res);
                if(res.status){
                    $('#product_img').attr('src', res.image);
                    $('#product_price').html(`$${res.price}`);
                }
            }
        });

});





</script>

@endsection