<?php

namespace App\Http\Controllers;

use App\Models\Product3D;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class Product3DController extends Controller
{
    public function index()
    {
        $products = Product3D::with(['parts', 'textures'])->get();
        return response()->json(['products' => $products], 200);
    }

    public function show($id)
    {
        $product = Product3D::with(['parts', 'textures'])->findOrFail($id);
        return response()->json(['product' => $product], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'file' => 'required|file',
            'price' => 'required|numeric',
            'model_id' => 'required|string',
            'category3d_id' => 'required|string',
            'delivery_price' => 'required|string',
            'shipping_price' => 'required|numeric',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        // رفع الملفات
        $filePath = $request->file('file')->store('');
    
        $videoPath = $request->hasFile('video') ? $request->file('video')->store('') : null;
    
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('');
            }
        }
    
        // إنشاء المنتج
        $product = Product3D::create([
            'name' => $request->name,
            'category3d_id' => $request->category3d_id,
            'desc' => $request->desc,
            'file' => $filePath,
            'price' => $request->price,
            'model_id' => $request->model_id,
            'video' => $videoPath,
            'images' => json_encode($images),
            'delivery_price' => $request->delivery_price,
            'shipping_price' => $request->shipping_price,
        ]);
    
        return response()->json(['product' => $product], 201);
    }
    
    public function update(Request $request, $id)
    {
        $product = Product3D::findOrFail($id);
    
        $request->merge([
            'file' => $request->file === 'null' ? null : $request->file,
            'video' => $request->video === 'null' ? null : $request->video,
        ]);
    
        $validator = Validator::make($request->all(), [
            'category3d_id' => 'required|string',
            'name' => 'string|max:255',
            'desc' => 'string|nullable',
            'file' => 'nullable|file',
            'price' => 'numeric|nullable',
            'model_id' => 'string|nullable',
            'delivery_price' => 'string|nullable',
            'shipping_price' => 'string|nullable',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        // تحديث الملفات
        $filePath = $product->file;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('');
        }
    
        $videoPath = $product->video;
        if ($request->hasFile('video')) {
            Storage::delete($videoPath);
            $videoPath = $request->file('video')->store('');
        }
    
        // معالجة الصور
        $images = json_decode($product->images, true) ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('');
            }
        }
    
        // تحديث المنتج
        $product->update([
            'name' => $request->name,
            'desc' => $request->desc,
            'file' => $filePath,
            'price' => $request->price,
            'model_id' => $request->model_id,
            'video' => $videoPath,
            'images' => json_encode($images),
            'delivery_price' => $request->delivery_price,
            'shipping_price' => $request->shipping_price,
        ]);
    
        return response()->json(['product' => $product], 200);
    }
    
    public function destroy($id)
    {
        $product = Product3D::findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }

    // Method to show 3D products by category

    public function index_product3d($Category3dID)
    { {
            $Product3D = Category3d::where('category3d_id', $Category3dID)->get();

            return response()->json(['data' => $Product3D], 200);

        }
    }
    public function getProductsByCategory($categoryId)
    {
        $products = Product3D::with(['parts', 'textures'])->where('category3d_id', $categoryId)->get();

        return response()->json(['products' => $products], 200);
    }

}
