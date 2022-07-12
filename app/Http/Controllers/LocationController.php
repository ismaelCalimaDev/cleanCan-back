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
}
