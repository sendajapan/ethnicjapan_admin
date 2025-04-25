<?php

namespace App\Http\Controllers\Admin;

use App\Helper\ApiResponseBuilder;
use App\Http\Controllers\Controller;
use App\Models\Part;
use App\Utils\CarBrandUtils;
use DB;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Utils;

class PartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.parts.edit');
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @throws FileNotFoundException
     */
    public function edit(string $id): View
    {
        $carBrandUtils = new CarBrandUtils();
        $parts = Part::where('vehicle_id', $id)->get();

        $brandLogo = $carBrandUtils->getCarThumbnail(strtolower($parts->first()->vehicle->make_title));

        return view('admin.parts.edit', compact(['parts', 'brandLogo']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            $part = Part::find($id);
            $part->quantity = $request->get('quantity');
            $part->price = $request->get('price');
            $part->save();

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error updating data: ' . $exception->getMessage());
        }

        return redirect()->back()->with('success', strtolower($part->partCategory->name) . ' updated successfully.');
    }

    public function print($vehicleId): View
    {
        $parts = Part::where('vehicle_id', $vehicleId)->get();
        return view('admin.parts.print', compact('parts'));
    }

    public function getPartsByGroup(Request $request): JsonResponse
    {
        $request->validate([
            'make_id' => 'required',
            'model_id' => 'required',
            'part_category_id' => 'required',
        ]);

        try {

            $parts = Part::whereHas('vehicle', function ($query) use ($request) {
                $query->where('make_id', $request->get('make_id'))->where('model_id', $request->get('model_id'));
            })->whereHas('partCategory', function ($query) use ($request) {
                $query->where('id', $request->get('part_category_id'));
            })->with(['vehicle', 'partCategory'])->get();

            $data = $parts->map(function ($part) {
                return [
                    'part_id' => $part->id,
                    'make_id' => $part->vehicle->make_id ?? '',
                    'make_title' => $part->vehicle->make_title ?? '',
                    'model_id' => $part->vehicle->model_id ?? '',
                    'model_title' => $part->vehicle->model_title ?? '',
                    'part_category' => $part->partCategory->name ?? '',
                    'quantity' => $part->quantity ?? 0,
                    'price' => $part->price ?? 0.0,
                ];
            });

            $cartContent = Cart::content();

            return ApiResponseBuilder::success(
                'success',
                ["data" => $data, "cartContent" => $cartContent],
                200
            );

        } catch (Exception $e) {

            return ApiResponseBuilder::error(
                'Failed to add product to cart. Please try again later.',
                ['error' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
