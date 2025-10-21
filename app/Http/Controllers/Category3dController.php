<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category3d;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Category3dController extends Controller
{
    public function index()
    {
        
        $categories = Category3d::all();
        return response()->json(['categories' => $categories], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'desc' => 'string|nullable',
            'file' => 'required',
            'categorymain3d_id' => 'required|string',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $file = $request->file('file');
        $filePath = $file->store('Category3d');
        $category = Category3d::create([
            'name' => $request->name,
            'desc' => $request->desc,
            'categorymain3d_id'=>$request->categorymain3d_id,
            'file' => $filePath,
        ]);
        return response()->json(['category' => $category], 201);
    }

    public function show($id)
    {
        // استخدام المعرف لإيجاد السجل
        $category = Category3d::findOrFail($id);

        // إعادة النتيجة في استجابة JSON
        return response()->json(['category' => $category], 200);
    }


    public function update(Request $request, Category3d $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'desc' => 'string|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        // عند التعديل يجب حذف الصورة القجيمة وعرض فقط الجديدة
        $file = $request->file('file');
        $filePath = $file->store('');

        $category->update([
            'name' => $request->input('name'),
            'desc' => $request->input('desc'),
            'file' => $filePath,
        ]);

        return response()->json(['category' => $category], 200);
    }
    
    
    public function destroy($id)
    {
        $category = Category3d::findOrFail($id);

        // حذف الملف المرتبط
        Storage::delete($category->file);

        // حذف الفئة
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully'], 200);
    }

    public function showByCategory3d($categoryId)
    {
        $category3d = Category3d::where('categorymain3d_id', $categoryId)->get();
        return response()->json(['category3d' => $category3d], 200);
    }

  



}
