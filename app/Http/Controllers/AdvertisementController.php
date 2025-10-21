<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{
    // عرض جميع الإعلانات
    public function index(Request $request)
    {
	$type = $request->type;
	if($type){
		$data = Advertisement::where('type', $type)->get();
	}else{
		$data = Advertisement::all();
	}

        return response()->json(['data' => $data], 200);
    }

    // إضافة إعلان جديد
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'url' => 'required',
            'type' => 'required|in:banner,special_offer',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $imagePath = $request->file('image')->store('advertisements');

        $advertisement = Advertisement::create([
            'image' => $imagePath,
            'url' => $request->url,
            'type' => $request->type,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json(['data' => $advertisement], 201);
    }

    // عرض إعلان معين
    public function show(Advertisement $advertisement)
    {
        return response()->json(['data' => $advertisement]);
    }

    // تحديث إعلان
    public function update(Request $request, Advertisement $advertisement)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'url' => 'required',
            'type' => 'required|in:banner,special_offer',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($advertisement->image);
            $imagePath = $request->file('image')->store('advertisements');
            $advertisement->image = $imagePath;
        }

        $advertisement->url = $request->url;
        $advertisement->type = $request->type;
        $advertisement->title = $request->title;
        $advertisement->description = $request->description;
        $advertisement->save();

        return response()->json(['data' => $advertisement]);
    }

    // حذف إعلان
    public function destroy(Advertisement $advertisement)
    {
        Storage::disk('public')->delete($advertisement->image);
        $advertisement->delete();

        return response()->json(['message' => 'Advertisement deleted successfully']);
    }
}