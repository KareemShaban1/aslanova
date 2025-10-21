<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProductPart;
use Illuminate\Http\Request;

class ProductPartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productParts = ProductPart::with(['product', 'part'])->get();
        return response()->json($productParts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products_3d,id',
            'part_id' => 'required|exists:parts,id',
        ]);

        $productPart = ProductPart::create($validated);

        return response()->json($productPart, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $productPart = ProductPart::with(['product', 'part'])->findOrFail($id);
        return response()->json($productPart);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $productPart = ProductPart::findOrFail($id);

        $validated = $request->validate([
            'product_id' => 'required|exists:products_3d,id',
            'part_id' => 'required|exists:parts,id',
        ]);

        $productPart->update($validated);

        return response()->json($productPart);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $productPart = ProductPart::findOrFail($id);
        $productPart->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
