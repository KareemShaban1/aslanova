<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;

class PartController extends Controller
{
    public function index()
    {
        $data = Part::with('products')->get();
        return response()->json(['data' => $data], 200);
    }

    public function show($id)
    {
        $data =  Part::with('products')->findOrFail($id);
        return response()->json(['data' => $data], 203);
    }

    public function store(Request $request)
    {
        $part = Part::create($request->all());
        return response()->json(['data' => $part], 201);
    }

    public function update(Request $request, $id)
    {
        $part = Part::findOrFail($id);
        $part->update($request->all());
        return response()->json(['data' => $part], 200);
    }

    public function destroy($id)
    {
        Part::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
