<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CategoryMain3D;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryMain3DController extends Controller
{
    public function index()
    {
        $categories = CategoryMain3D::all();
        return response()->json(['categories' => $categories], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'desc' => 'string|nullable',
            'file' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }


        $file = $request->file('file');
        $filePath = $file->store('Category3d');
        $category = CategoryMain3D::create([
            'name' => $request->name,
            'desc' => $request->desc,
            'file' => $filePath,
        ]);

        return response()->json(['category' => $category], 201);
    }

    public function show($id)
    {
        $category = CategoryMain3D::findOrFail($id);
        return response()->json(['category' => $category], 200);
    }

    public function update(Request $request, $id)
    {
        $category = CategoryMain3D::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'desc' => 'string|nullable',
            'file' => 'nullable|file',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        if ($request->hasFile('file')) {
            Storage::delete($category->file);
            $filePath = $request->file('file')->store('');
        } else {
            $filePath = $category->file;
        }

        $category->update([
            'name' => $request->input('name'),
            'desc' => $request->input('desc'),
            'file' => $filePath,
        ]);

        return response()->json(['category' => $category], 200);
    }

    public function destroy($id)
    {
        $category = CategoryMain3D::findOrFail($id);

        Storage::delete($category->file);
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully'], 200);
    }


    
}
