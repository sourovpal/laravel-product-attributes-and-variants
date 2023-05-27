<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    //


    public function index()
    {
        return view('attribute');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:attributes,name']);

        Attribute::create(['name' => $request->name]);

        return back()->withSuccess('Success!');
    }
}
