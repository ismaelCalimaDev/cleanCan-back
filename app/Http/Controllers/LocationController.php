<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getLoggedUserLocations()
    {
        return response()->json([
            'status' => true,
            'locations' => auth()->user()->locations()->get(),
        ]);
    }
    public function createLocation(Request $request)
    {
        $validate = $request->validate([
            'type' => 'required',
            'province' => 'required',
            'postal_code' => 'required',
            'street' => 'required',
        ]);
        Location::create([
            'user_id' => auth()->user()->id,
            'type' => $validate['type'],
            'province' => $validate['province'],
            'postal_code' => $validate['postal_code'],
            'street' => $validate['street']
        ]);

        return response()->json([
            'status' => true,
            'locations' => auth()->user()->locations()->get(),
        ]);
    }
    public function editLocation($id, Request $request) {
        $validate = $request->validate([
            'type' => 'required',
            'province' => 'required',
            'postal_code' => 'required',
            'street' => 'required',
        ]);
        Location::where('id', $id)->update([
            'type' => $validate['type'],
            'province' => $validate['province'],
            'postal_code' => $validate['postal_code'],
            'street' => $validate['street']
        ]);

        return response()->json([
            'status' => true,
            'locations' => auth()->user()->locations()->get(),
        ]);
    }
    public function deleteLocation($id) {
        Location::where('id', $id)->delete();
        return response()->json([
            'status' => true,
            'locations' => auth()->user()->locations()->get(),
        ]);
    }
    public function getLocation($id) {
        return response()->json([
            'status' => true,
            'locations' => Location::findOrFail($id),
        ]);
    }
}
