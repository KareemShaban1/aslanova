<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();
        return response()->json($locations);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'country' => 'required|string',
            'street' => 'required|string',
            'address' => 'required|string',
            'zip_code' => 'required|string',
            'location' => 'required|string',
            'phone' => 'required|string',
        ]);

        $location = Location::create($request->all());
        return response()->json($location, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'country' => 'required|string',
            'street' => 'required|string',
            'address' => 'required|string',
            'zip_code' => 'required|string',
            'location' => 'required|string',
            'phone' => 'required|string',
        ]);

        $location = Location::findOrFail($id);
        $location->update($request->all());

        return response()->json($location);
    }

    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        return response()->json(null, 204);
    }
}
