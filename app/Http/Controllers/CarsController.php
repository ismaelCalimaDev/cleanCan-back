<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarsController extends Controller
{
    public function getLoggedUserCars()
    {
        return response()->json([
            'status' => true,
            'cars' => auth()->user()->cars()->get(),
        ]);
    }
    public function createCar(Request $request)
    {
        $validate = $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'plate' => 'required',
            'color' => 'required',
        ]);
        Car::create([
            'user_id' => auth()->user()->id,
            'brand' => $validate['brand'],
            'model' => $validate['model'],
            'plate' => $validate['plate'],
            'color' => $validate['color']
        ]);

        return response()->json([
            'status' => true,
            'cars' => auth()->user()->cars()->get(),
        ]);
    }
    public function editCar($id, Request $request) {
        $validate = $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'plate' => 'required',
            'color' => 'required',
        ]);
        Car::where('id', $id)->update([
            'user_id' => auth()->user()->id,
            'brand' => $validate['brand'],
            'model' => $validate['model'],
            'plate' => $validate['plate'],
            'color' => $validate['color']
        ]);

        return response()->json([
            'status' => true,
            'cars' => Car::where('id', $id)->get(),
        ]);
    }
    public function deleteCar($id) {
        Car::where('id', $id)->delete();
        return response()->json([
            'status' => true,
            'cars' => auth()->user()->cars()->get(),
        ]);
    }
    public function getCar($id) {
        return response()->json([
            'status' => true,
            'cars' => Car::findOrFail($id),
        ]);
    }
}
