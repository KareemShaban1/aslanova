<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::all();
        return response()->json(['offers' => $offers], 200);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'file' => 'required|file',
            'delivery_price' => 'required|string',
            'shipping_price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // حفظ الملف
        $file = $request->file('file');
        $filePath = $file->store('offers'); // حفظ الملفات في مجلد 'offers'

        $offer = Offer::create([
            'name' => $request->name,
            'price' => $request->price,
            'old_price' => $request->old_price,
            'description' => $request->description,
            'file' => $filePath,
            'delivery_price' => $request->delivery_price,
            'shipping_price' => $request->shipping_price,
        ]);

        return response()->json(['offer' => $offer], 201);
    }

    public function show(Offer $offer)
    {
        return response()->json(['offer' => $offer], 200);
    }

    public function update(Request $request, Offer $offer)
    {
        // dd($request->all() , $offer);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'file' => 'nullable|file',
            'delivery_price' => 'required|string',
            'shipping_price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // حذف الملف القديم وتخزين الملف الجديد إذا تم رفع ملف جديد
        $filePath = $offer->file;
        if ($request->hasFile('file')) {
            if ($filePath) {
                \Storage::delete($filePath);
            }
            $filePath = $request->file('file')->store('offers');
        }

        $offer->update([
            'name' => $request->name,
            'price' => $request->price,
            'old_price' => $request->old_price,
            'description' => $request->description,
            'file' => $filePath,
            'delivery_price' => $request->delivery_price,
            'shipping_price' => $request->shipping_price,
        ]);

        return response()->json(['offer' => $offer], 200);
    }

    public function destroy(Offer $offer)
    {
        if ($offer->file) {
            \Storage::delete($offer->file);
        }
        $offer->delete();

        return response()->json(['message' => 'Offer deleted successfully'], 200);
    }
}
