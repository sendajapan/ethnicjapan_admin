<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Utils\CarBrandUtils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = Vehicle::all();
        return view('admin.vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        $carBrandUtils = new CarBrandUtils();
        $brandLogo = $carBrandUtils->getCarThumbnail(strtolower($vehicle->make_title));
        return view('admin.vehicles.show', compact('vehicle', 'brandLogo'));
    }

    public function showParts(Vehicle $vehicle)
    {
        return view('admin.vehicles.index', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getModels(Request $request): JsonResponse
    {
        $request->validate([
            'makes' => 'array',
            'makes.*' => 'string',
        ]);

        $models = Vehicle::whereIn('make_id', $request->makes)
            ->select(['model_id', 'model_title'])
            ->distinct()
            ->orderBy('model_title')
            ->get();

        return response()->json(['models' => $models]);
    }
}
