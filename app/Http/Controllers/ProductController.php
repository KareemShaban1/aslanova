<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return response()->json(['products' => $products], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'desc' => 'string|nullable',
            'type' => 'string|nullable',
            'file' => 'required|file',
            'Width' => 'required|numeric',
            'Height' => 'required|numeric',
            'Thickness' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // حفظ الملف
        $file = $request->file('file');
        $filePath = $file->store('Product'); // يمكنك تخصيص المسار حسب الحاجة

        // إنشاء سجل في قاعدة البيانات
        $product = Product::create([
            'category_id' => $request->category_id,
            'file' => $filePath,
            'name' => $request->name,
            'desc' => $request->desc,
            'type' => $request->type,
            'Width' => $request->Width,
            'Height' => $request->Height,
            'Thickness' => $request->Thickness,

        ]);

        return response()->json(['product' => $product], 201);
    }

    public function show(Product $product)
    {
        return response()->json(['product' => $product], 200);
    }

    public function update(Request $request, Product $product)
    {

        $file = $request->file('file');
        $filePath = $file->store(''); // يمكنك تخصيص المسار حسب الحاجة

        $product->update([
            'category_id' => $request->category_id,
            'file' => $filePath,
            'name' => $request->name,
            'desc' => $request->desc,
            'type' => $request->type,
            'Width' => $request->Width,
            'Height' => $request->Height,
            'Thickness' => $request->Thickness,
        ]);

        return response()->json(['product' => $product], 200);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }

    // لعرض المنتجات لفئة معينة
    public function showByCategory($categoryId)
    {
        $products = Product::where('category_id', $categoryId)->get();

        return response()->json(['products' => $products], 200);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('q');

        $products = Product::where('name', 'like', "%{$keyword}%")
            ->orWhere('desc', 'like', "%{$keyword}%")
            ->with('category')
            ->get();


        if (auth()->check()) {
	dd($products);
            foreach ($products as $product) {
                \App\Models\UserSearchHistory::updateOrCreate(
                    [
                        'user_id' => auth()->id(),
                        'product_id' => $product->id,
                    ],
                    [
                        'category_id' => $product->category_id,
                    ]
                );
            }
        }

        return response()->json(['products' => $products]);
    }

    public function storeUserSearchHistory(Request $request)
    {
        $user = User::find($request->user_id);
        if (! $user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $product = Product::find($request->product_id);
        $user->searchHistories()->updateOrCreate([
            'user_id' => $user->id,
            'product_id' => $request->product_id,
        ], [
            'category_id' => $product->category_id,
        ]);

        return response()->json(['message' => 'User search history stored successfully'], 200);
    }
    public function suggestedProducts(Request $request)
    {
        $user = User::find($request->user_id);
        if (! $user) {
            return response()->json(['products' => []]);
        }

        $categoryIds = $user->searchHistories()
            ->distinct('category_id')
            ->pluck('category_id');

	$products = Product::whereIn('category_id', $categoryIds)
		->latest()
            ->take(10)
            ->get();

        return response()->json(['products' => $products]);
    }

    // الخاص بعرض بيانات المنتج الفرعية المرتبطة في المنتج

}