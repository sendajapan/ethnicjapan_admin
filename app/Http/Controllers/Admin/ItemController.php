<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ItemsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Item;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(ItemsDataTable $dataTable)
    {
        return $dataTable->render('admin.item.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.item.create');
    }

    /**
     * Store a newly created resource in storage.
     * @throws Throwable
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'item_name' => 'required|string|max:255',
            'item_description' => 'max:255',
            'hts_code' => 'max:255',
            'default_price' => 'max:20',
            'item_photo' => 'file|mimes:jpg,png,webp|max:5120',
            'vegan_declaration' => 'file|mimes:jpg,png,pdf|max:20480',
            'traceability_exercise' => 'file|mimes:jpg,png,pdf|max:20480',
            'non_gmo_declaration' => 'file|mimes:jpg,png,pdf|max:20480',
            'nutrition_chart' => 'file|mimes:jpg,png,pdf|max:20480',
            'gluten_free' => 'file|mimes:jpg,png,pdf|max:20480',
            'heavy_metals_declaration' => 'file|mimes:jpg,png,pdf|max:20480',
            'security_plan' => 'file|mimes:jpg,png,pdf|max:20480',
            'rainforest_alliance' => 'file|mimes:jpg,png,pdf|max:20480',
            'fair_trade' => 'file|mimes:jpg,png,pdf|max:20480',
            'product_flow_chart' => 'file|mimes:jpg,png,pdf|max:20480',
            'kosher_certification_if_needed' => 'file|mimes:jpg,png,pdf|max:20480',
            'halal_certification_if_needed' => 'file|mimes:jpg,png,pdf|max:20480',
            'spec_sheet' => 'file|mimes:jpg,png,pdf|max:20480',
            'producer_organic_certification_eu' => 'file|mimes:jpg,png,pdf|max:20480',
            'producer_organic_certification_cor' => 'file|mimes:jpg,png,pdf|max:20480',
            'producer_organic_certification_nop' => 'file|mimes:jpg,png,pdf|max:20480',
            'producer_organic_certification_jas' => 'file|mimes:jpg,png,pdf|max:20480',
            'organic_certification_jas_exporter_eu' => 'file|mimes:jpg,png,pdf|max:20480',
            'organic_certification_jas_exporter_cor' => 'file|mimes:jpg,png,pdf|max:20480',
            'organic_certification_jas_exporter_nop' => 'file|mimes:jpg,png,pdf|max:20480',
            'organic_certification_jas_exporter_jas' => 'file|mimes:jpg,png,pdf|max:20480'
        ]);
        DB::beginTransaction();




        try {
            $item = new Item();
            $item->item_name = $request->input('item_name');
            $item->category_id = $request->input('category_id');
            $item->item_origin = $request->input('item_origin');
            $item->item_description = $request->input('item_description');
            $item->hts_code = $request->input('hts_code');
            $item->default_price = $request->input('default_price');

            if ($request->hasFile('item_photo')) {
                unset($filePath);
                $filePath = $request->file('item_photo')->store('uploads/item_photos', 'public');
                $item->item_photo = $filePath;
            }

            if ($request->hasFile('vegan_declaration')) {
                unset($filePath);
                $filePath = $request->file('vegan_declaration')->store('uploads/item_certificates', 'public');
                $item->vegan_declaration = $filePath;
            }
            if ($request->hasFile('traceability_exercise')) {
                unset($filePath);
                $filePath = $request->file('traceability_exercise')->store('uploads/item_certificates', 'public');
                $item->traceability_exercise = $filePath;
            }
            if ($request->hasFile('non_gmo_declaration')) {
                unset($filePath);
                $filePath = $request->file('non_gmo_declaration')->store('uploads/item_certificates', 'public');
                $item->non_gmo_declaration = $filePath;
            }
            if ($request->hasFile('nutrition_chart')) {
                unset($filePath);
                $filePath = $request->file('nutrition_chart')->store('uploads/item_certificates', 'public');
                $item->nutrition_chart = $filePath;
            }
            if ($request->hasFile('gluten_free')) {
                unset($filePath);
                $filePath = $request->file('gluten_free')->store('uploads/item_certificates', 'public');
                $item->gluten_free = $filePath;
            }
            if ($request->hasFile('heavy_metals_declaration')) {
                unset($filePath);
                $filePath = $request->file('heavy_metals_declaration')->store('uploads/item_certificates', 'public');
                $item->heavy_metals_declaration = $filePath;
            }
            if ($request->hasFile('security_plan')) {
                unset($filePath);
                $filePath = $request->file('security_plan')->store('uploads/item_certificates', 'public');
                $item->security_plan = $filePath;
            }
            if ($request->hasFile('rainforest_alliance')) {
                unset($filePath);
                $filePath = $request->file('rainforest_alliance')->store('uploads/item_certificates', 'public');
                $item->rainforest_alliance = $filePath;
            }
            if ($request->hasFile('fair_trade')) {
                unset($filePath);
                $filePath = $request->file('fair_trade')->store('uploads/item_certificates', 'public');
                $item->fair_trade = $filePath;
            }
            if ($request->hasFile('product_flow_chart')) {
                unset($filePath);
                $filePath = $request->file('product_flow_chart')->store('uploads/item_certificates', 'public');
                $item->product_flow_chart = $filePath;
            }
            if ($request->hasFile('kosher_certification_if_needed')) {
                unset($filePath);
                $filePath = $request->file('kosher_certification_if_needed')->store('uploads/item_certificates', 'public');
                $item->kosher_certification_if_needed = $filePath;
            }
            if ($request->hasFile('halal_certification_if_needed')) {
                unset($filePath);
                $filePath = $request->file('halal_certification_if_needed')->store('uploads/item_certificates', 'public');
                $item->halal_certification_if_needed = $filePath;
            }
            if ($request->hasFile('spec_sheet')) {
                unset($filePath);
                $filePath = $request->file('spec_sheet')->store('uploads/item_certificates', 'public');
                $item->spec_sheet = $filePath;
            }
            if ($request->hasFile('producer_organic_certification_eu')) {
                unset($filePath);
                $filePath = $request->file('producer_organic_certification_eu')->store('uploads/item_certificates', 'public');
                $item->producer_organic_certification_eu = $filePath;
            }
            if ($request->hasFile('producer_organic_certification_cor')) {
                unset($filePath);
                $filePath = $request->file('producer_organic_certification_cor')->store('uploads/item_certificates', 'public');
                $item->producer_organic_certification_cor = $filePath;
            }
            if ($request->hasFile('producer_organic_certification_nop')) {
                unset($filePath);
                $filePath = $request->file('producer_organic_certification_nop')->store('uploads/item_certificates', 'public');
                $item->producer_organic_certification_nop = $filePath;
            }
            if ($request->hasFile('producer_organic_certification_jas')) {
                unset($filePath);
                $filePath = $request->file('producer_organic_certification_jas')->store('uploads/item_certificates', 'public');
                $item->producer_organic_certification_jas = $filePath;
            }
            if ($request->hasFile('organic_certification_jas_exporter_eu')) {
                unset($filePath);
                $filePath = $request->file('organic_certification_jas_exporter_eu')->store('uploads/item_certificates', 'public');
                $item->organic_certification_jas_exporter_eu = $filePath;
            }
            if ($request->hasFile('organic_certification_jas_exporter_cor')) {
                unset($filePath);
                $filePath = $request->file('organic_certification_jas_exporter_cor')->store('uploads/item_certificates', 'public');
                $item->organic_certification_jas_exporter_cor = $filePath;
            }
            if ($request->hasFile('organic_certification_jas_exporter_nop')) {
                unset($filePath);
                $filePath = $request->file('organic_certification_jas_exporter_nop')->store('uploads/item_certificates', 'public');
                $item->organic_certification_jas_exporter_nop = $filePath;
            }
            if ($request->hasFile('organic_certification_jas_exporter_jas')) {
                unset($filePath);
                $filePath = $request->file('organic_certification_jas_exporter_jas')->store('uploads/item_certificates', 'public');
                $item->organic_certification_jas_exporter_jas = $filePath;
            }


            $item->save();
            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error inserting ' . $item->item_name . ': ' . $exception->getMessage());
        }

        return redirect()->route('admin.item.index')->with('success', $item->item_name . ' inserted successfully.');
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
     */
    public function edit(string $id)
    {
        $data = Item::where('id', $id)->firstOrFail();

        return view('admin.item.edit', compact('data'));
    }


    public function detail(string $id)
    {
        $data = Item::where('id', $id)->firstOrFail();

        return view('admin.item.detail', compact('data'));
    }



    /**
     * Update the specified resource in storage.
     * @throws Throwable
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $item = Item::where('id', $id)->firstOrFail();
            $item->item_name = strtoupper($request->input('item_name'));
            $item->item_description = $request->input('item_description');
            $item->category_id = $request->input('category_id');
            $item->item_origin = $request->input('item_origin');
            $item->hts_code = $request->input('hts_code');
            $item->default_price = $request->input('default_price');

            if ($request->hasFile('item_photo')) {
                unset($filePath);
                $filePath = $request->file('item_photo')->store('uploads/item_photos', 'public');
                $item->item_photo = $filePath;
            }

            if ($request->hasFile('vegan_declaration')) {
                unset($filePath);
                $filePath = $request->file('vegan_declaration')->store('uploads/item_certificates', 'public');
                $item->vegan_declaration = $filePath;
            }
            if ($request->hasFile('traceability_exercise')) {
                unset($filePath);
                $filePath = $request->file('traceability_exercise')->store('uploads/item_certificates', 'public');
                $item->traceability_exercise = $filePath;
            }
            if ($request->hasFile('non_gmo_declaration')) {
                unset($filePath);
                $filePath = $request->file('non_gmo_declaration')->store('uploads/item_certificates', 'public');
                $item->non_gmo_declaration = $filePath;
            }
            if ($request->hasFile('nutrition_chart')) {
                unset($filePath);
                $filePath = $request->file('nutrition_chart')->store('uploads/item_certificates', 'public');
                $item->nutrition_chart = $filePath;
            }
            if ($request->hasFile('gluten_free')) {
                unset($filePath);
                $filePath = $request->file('gluten_free')->store('uploads/item_certificates', 'public');
                $item->gluten_free = $filePath;
            }
            if ($request->hasFile('heavy_metals_declaration')) {
                unset($filePath);
                $filePath = $request->file('heavy_metals_declaration')->store('uploads/item_certificates', 'public');
                $item->heavy_metals_declaration = $filePath;
            }
            if ($request->hasFile('security_plan')) {
                unset($filePath);
                $filePath = $request->file('security_plan')->store('uploads/item_certificates', 'public');
                $item->security_plan = $filePath;
            }
            if ($request->hasFile('rainforest_alliance')) {
                unset($filePath);
                $filePath = $request->file('rainforest_alliance')->store('uploads/item_certificates', 'public');
                $item->rainforest_alliance = $filePath;
            }
            if ($request->hasFile('fair_trade')) {
                unset($filePath);
                $filePath = $request->file('fair_trade')->store('uploads/item_certificates', 'public');
                $item->fair_trade = $filePath;
            }
            if ($request->hasFile('product_flow_chart')) {
                unset($filePath);
                $filePath = $request->file('product_flow_chart')->store('uploads/item_certificates', 'public');
                $item->product_flow_chart = $filePath;
            }
            if ($request->hasFile('kosher_certification_if_needed')) {
                unset($filePath);
                $filePath = $request->file('kosher_certification_if_needed')->store('uploads/item_certificates', 'public');
                $item->kosher_certification_if_needed = $filePath;
            }
            if ($request->hasFile('halal_certification_if_needed')) {
                unset($filePath);
                $filePath = $request->file('halal_certification_if_needed')->store('uploads/item_certificates', 'public');
                $item->halal_certification_if_needed = $filePath;
            }
            if ($request->hasFile('spec_sheet')) {
                unset($filePath);
                $filePath = $request->file('spec_sheet')->store('uploads/item_certificates', 'public');
                $item->spec_sheet = $filePath;
            }
            if ($request->hasFile('producer_organic_certification_eu')) {
                unset($filePath);
                $filePath = $request->file('producer_organic_certification_eu')->store('uploads/item_certificates', 'public');
                $item->producer_organic_certification_eu = $filePath;
            }
            if ($request->hasFile('producer_organic_certification_cor')) {
                unset($filePath);
                $filePath = $request->file('producer_organic_certification_cor')->store('uploads/item_certificates', 'public');
                $item->producer_organic_certification_cor = $filePath;
            }
            if ($request->hasFile('producer_organic_certification_nop')) {
                unset($filePath);
                $filePath = $request->file('producer_organic_certification_nop')->store('uploads/item_certificates', 'public');
                $item->producer_organic_certification_nop = $filePath;
            }
            if ($request->hasFile('producer_organic_certification_jas')) {
                unset($filePath);
                $filePath = $request->file('producer_organic_certification_jas')->store('uploads/item_certificates', 'public');
                $item->producer_organic_certification_jas = $filePath;
            }
            if ($request->hasFile('organic_certification_jas_exporter_eu')) {
                unset($filePath);
                $filePath = $request->file('organic_certification_jas_exporter_eu')->store('uploads/item_certificates', 'public');
                $item->organic_certification_jas_exporter_eu = $filePath;
            }
            if ($request->hasFile('organic_certification_jas_exporter_cor')) {
                unset($filePath);
                $filePath = $request->file('organic_certification_jas_exporter_cor')->store('uploads/item_certificates', 'public');
                $item->organic_certification_jas_exporter_cor = $filePath;
            }
            if ($request->hasFile('organic_certification_jas_exporter_nop')) {
                unset($filePath);
                $filePath = $request->file('organic_certification_jas_exporter_nop')->store('uploads/item_certificates', 'public');
                $item->organic_certification_jas_exporter_nop = $filePath;
            }
            if ($request->hasFile('organic_certification_jas_exporter_jas')) {
                unset($filePath);
                $filePath = $request->file('organic_certification_jas_exporter_jas')->store('uploads/item_certificates', 'public');
                $item->organic_certification_jas_exporter_jas = $filePath;
            }

            $item->save();
            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error updating data: ' . $exception->getMessage());
        }

        return redirect()->route('admin.item.index')->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Item::where('id', $id)->firstOrFail()->delete();
        } catch (Exception $exception){
            return response(array('code' => 403, 'status' => 'failed', 'message' => $exception->getMessage()), 403, array('Content-Type' => 'application/json'));
        }

        return response(array('code' => 200,
            'status' => 'success',
            'message' => 'Item deleted successfully!',
        ), 200, array('Content-Type' => 'application/json'));
    }
}
