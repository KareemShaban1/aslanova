<?php

namespace App\Http\Controllers;

use App\Models\Texture;
use Illuminate\Http\Request;

class TextureController extends Controller
{
    public function index()
    {
        $data = Texture::with(['products', 'material'])->get();
        return response()->json(['data' => $data], 200);
    }

    public function show($id)
    {
        $data = Texture::with(['products', 'material'])->findOrFail($id);
        return response()->json(['data' => $data], 203);
    }

    public function store(Request $request)
    {
        $texture = Texture::create($request->all());
        return response()->json(['data' => $texture], 201);
    }

    public function update(Request $request, $id)
    {
        $texture = Texture::findOrFail($id);
        $texture->update($request->all());
        return response()->json(['data' => $texture], 200);
    }

    public function destroy($id)
    {
        Texture::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
    public function getTexturesByMaterial($materialId)
    {
        $data = Texture::with(['products', 'material'])->where('material_id', $materialId)->get();

        return response()->json(['data' => $data], 200);
    }
}
