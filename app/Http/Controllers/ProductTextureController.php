<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProductTexture;
use Illuminate\Http\Request;

class ProductTextureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productTextures = ProductTexture::with(['product', 'texture'])->get();
        return response()->json($productTextures);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products_3d,id',
            'texture_id' => 'required|exists:textures,id',
        ]);

        $productTexture = ProductTexture::create($validated);

        return response()->json($productTexture, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $productTexture = ProductTexture::with(['product', 'texture'])->findOrFail($id);
        return response()->json($productTexture);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $productTexture = ProductTexture::findOrFail($id);

        $validated = $request->validate([
            'product_id' => 'required|exists:products_3d,id',
            'texture_id' => 'required|exists:textures,id',
        ]);

        $productTexture->update($validated);

        return response()->json($productTexture);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $productTexture = ProductTexture::findOrFail($id);
        $productTexture->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
