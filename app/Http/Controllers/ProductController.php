<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function all()
    {
        return view('all');
    }
    public function details(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;
            $variants = $request->input('variants');
            sort($variants);
            $variants_slug =  implode('-', $variants);


            $product = ProductVariant::where('product_id', $id)->where('variants_slug', $variants_slug)->first();

            if ($product) {
                return response()->json([
                    'status' => true,
                    'image' => asset('upload/' . $product->image),
                    'price' => $product->price,
                ]);
            } else {
                $product = Product::find($request->id);
                if ($product) {
                    return response()->json([
                        'status' => true,
                        'image' => asset('upload/' . $product->image),
                        'price' => $product->price,
                    ]);
                }
                return response()->json([
                    'status' => false
                ]);
            }
        }
        $product = Product::findOrFail($request->id);

        return view('details', compact('product'));
    }
    public function index()
    {
        return view('products');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'required|image',
        ]);


        $data = [];

        $data['title'] = $request->title;
        $data['description'] = $request->description;
        $data['price'] = $request->price;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'product-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload'), $filename);
            $data['image'] = $filename;
        }

        $product = Product::create($data);
        if ($product && $request->input('attributes') && (count($request->input('attributes')) > 0)) {
            foreach ($request->input('attributes') as $attr) {
                $attribute = Attribute::find($attr);
                ProductAttribute::create([
                    'product_id' => $product->id,
                    'attribute_id' => optional($attribute)->id ?? 0,
                    'attribute_name' => optional($attribute)->name ?? '',
                ]);
            }
            return redirect()->route('product.edit', $product->id);
        }
        return back()->withSuccess('Success!');
    }

    public function edit(Request $request)
    {

        $product = Product::findOrFail($request->id);
        $productAttr = ProductAttribute::where('product_id', $request->id)->get();

        $attributeValues = [];
        foreach ($productAttr as $key => $attr) {
            $attributeValues[] = AttributeValue::where('attribute_id', $attr->attribute_id)->pluck('value');
        }
        $attributeValues = $this->get_combinations($attributeValues);

        return view('edit-product', compact('product', 'attributeValues'));
    }


    public function update(Request $request)
    {


        $product = Product::findOrFail($request->id);

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'nullable|image',
        ]);


        $data = [];

        $data['title'] = $request->title;
        $data['description'] = $request->description;
        $data['price'] = $request->price;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'product-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload'), $filename);
            $data['image'] = $filename;
        }

        $product->update($data);

        $variantList = $request->input('product_variants');

        foreach ($variantList as $key => $list) {
            if ($list['price'] > 0) {
                $data = [];
                sort($list['variants']);
                $variants_slug =  implode('-', $list['variants']);
                $variants_string =  implode(', ', $list['variants']);
                if ($request->hasFile('product_image')) {
                    if (array_key_exists($key, $request->file('product_image'))) {
                        $file =  $request->file('product_image')[$key];
                        $filename = $variants_slug . '-' . time() * time() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('/upload'), Str::slug($filename));
                        $data['image'] = Str::slug($filename);
                    }
                }
                $data['product_id'] = $product->id;
                $data['variants_string'] = $variants_string;
                $data['variants_slug'] = $variants_slug;
                $data['price'] = $list['price'];
                ProductVariant::updateOrCreate(['product_id' => $product->id, 'variants_slug' => $variants_slug], $data);
            }
        }
        return back()->withSuccess("Updated Successful.");
    }

    public function get_combinations($arrays)
    {
        $result = array(array());
        foreach ($arrays as $property => $property_values) {
            $tmp = array();
            foreach ($result as $result_item) {
                foreach ($property_values as $property_value) {
                    $tmp[] = $result_item + array(uniqid() => $property_value);
                }
            }
            $result = $tmp;
        }
        return $result;
    }
}
