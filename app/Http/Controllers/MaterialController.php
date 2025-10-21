<?php
namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        // 'textures',
        $data = Material::with([ 'children'])->get(); 
        return response()->json(['data' => $data], 200);
    }

    public function show($id)
    {
        $data = Material::with(['textures', 'children'])->findOrFail($id);
        return  response()->json(['data' => $data], 203);
    }

    public function store(Request $request)
    {
        $material = Material::create($request->all());
        return response()->json(['data' => $material], 201);
    }

    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);
        $material->update($request->all());
        return response()->json(['data' => $material], 200);
    }

    public function destroy($id)
    {
        Material::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
