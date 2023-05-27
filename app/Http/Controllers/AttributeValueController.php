<?php

namespace App\Http\Controllers;

use App\Models\AttributeValue;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    public function index()
    {
        return view('variant');
    }

    public function store(Request $request)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|unique:attribute_values,value'
        ]);

        AttributeValue::create([
            'attribute_id' => $request->attribute_id,
            'value' => strtolower($request->value),
        ]);

        return back()->withSuccess('Success!');
    }
}
