<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SubProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class SubProductController extends Controller
{

    public function index()
    {
        $subProducts = SubProduct::all();
        return response()->json([
            'data' => $subProducts,
        ]);
    }

    public function show($id)
    {
        $subProduct = SubProduct::findOrFail($id);
        return response()->json([
            'data' => $subProduct,
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'file' => 'required|file',
            'color' => 'required|string',
            'description' => 'required|string',
            'capital' => 'required|string',
            'price' => 'required|string',
            'quantity' => 'required|string',
            'delivery_price' => 'required|string',
            'shipping_price' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
    
        $file = $request->file('file');
        $filePath = $file->store('');
    
        $videoPath = null;
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $videoPath = $video->store('');
        }
    
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('');
            }
        }
    
        $product = Product::findOrFail($request->product_id);
    
        $subProduct = SubProduct::create([
            'product_id' => $request->product_id,
            'file' => $filePath,
            'color' => $request->color,
            'name' => $request->name,
            'desc' => $request->description,
            'type' => $product->type,
            'price' => $request->price,
            'capital' => $request->capital,
            'quantity' => $request->quantity,
            'Width' => $product->Width,
            'Height' => $product->Height,
            'Thickness' => $product->Thickness,
            'video' => $videoPath,
            'images' => json_encode($images),
            'delivery_price' => $request->delivery_price,
            'shipping_price' => $request->shipping_price,
        ]);
    
        return response()->json([
            'data' => $subProduct,
        ], 201);
    }
    public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'color' => 'required|string',
        ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    $subProduct = SubProduct::findOrFail($id);
    $product = Product::findOrFail($request->product_id);

    $filePath = $subProduct->file;
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $filePath = $file->store('');
    }

    $videoPath = $subProduct->video;
    if ($request->hasFile('video')) {
        if ($videoPath) {
            Storage::delete($videoPath);
        }
        $video = $request->file('video');
        $videoPath = $video->store('');
    }

    $images = json_decode($subProduct->images, true) ?? [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $images[] = $image->store('');
        }
    }

    $subProduct->update([
        'product_id' => $request->product_id,
        'file' => $filePath,
        'color' => $request->color,
        'name' => $request->name,
        'desc' => $request->desc,
        'type' => $product->type,
        'price' => $request->price,
        'capital' => $request->capital,
        'quantity' => $request->quantity,
        'Width' => $product->Width,
        'Height' => $product->Height,
        'Thickness' => $product->Thickness,
        'video' => $videoPath,
        'images' => json_encode($images),
        'delivery_price' => $request->delivery_price,
        'shipping_price' => $request->shipping_price,
    ]);

    return response()->json([
        'data' => $subProduct,
    ], 200);
}


    public function destroy($id)
    {
        $subProduct = SubProduct::findOrFail($id);
        $subProduct->delete();
        return response()->json(null, 204);
    }

    public function index_subproducts($productId)
    {
        $subProduct = SubProduct::where('product_id', $productId)->get();

        return response()->json(['data' => $subProduct], 200);

    }

}
