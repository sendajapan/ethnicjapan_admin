<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProvidersDataTable;
use App\Http\Controllers\Controller;
use App\Models\Provider;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(ProvidersDataTable $dataTable)
    {
        return $dataTable->render('admin.provider.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.provider.create');
    }



    public function detail(string $id)
    {
        $data = Provider::where('id', $id)->firstOrFail();

        return view('admin.provider.detail', compact('data'));
    }


    /**
     * Store a newly created resource in storage.
     * @throws Throwable
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'provider_name' => 'required|string|max:255'
        ]);

        DB::beginTransaction();

        try {
            $provider = new Provider();
            $provider->provider_name = $request->input('provider_name');
            $provider->provider_country_name = $request->input('provider_country_name');
            $provider->provider_company_name = $request->input('provider_company_name');
            $provider->provider_physical_address = $request->input('provider_physical_address');
            $provider->provider_pickup_address = $request->input('provider_pickup_address');
            $provider->provider_remit_address = $request->input('provider_remit_address');
            $provider->provider_office_phone = $request->input('provider_office_phone');
            $provider->provider_primary_contact_name = $request->input('provider_primary_contact_name');
            $provider->provider_primary_contact_email = $request->input('provider_primary_contact_email');
            $provider->provider_account_receivable_contact_email = $request->input('provider_account_receivable_contact_email');
            $provider->provider_food_safety_contact_email = $request->input('provider_food_safety_contact_email');
            $provider->provider_food_safety_contact_phone = $request->input('provider_food_safety_contact_phone');
            $provider->provider_emergency_recall_contact_phone = $request->input('provider_emergency_recall_contact_phone');
            $provider->provider_emergency_recall_contact_email = $request->input('provider_emergency_recall_contact_email');
            $provider->provider_list_of_products = $request->input('provider_list_of_products');
            $provider->gfsi_processing_plant_certification_type = $request->input('gfsi_processing_plant_certification_type');


            if ($request->hasFile('gfsi_processing_plant_certification_file')) {
                unset($filePath);
                $filePath = $request->file('gfsi_processing_plant_certification_file')->store('uploads/provider_docs', 'public');
                $provider->gfsi_processing_plant_certification_file = $filePath;
            }

            if ($request->hasFile('social_certification_smeta')) {
                unset($filePath);
                $filePath = $request->file('social_certification_smeta')->store('uploads/provider_docs', 'public');
                $provider->social_certification_smeta = $filePath;
            }

            if ($request->hasFile('fda_registration')) {
                unset($filePath);
                $filePath = $request->file('fda_registration')->store('uploads/provider_docs', 'public');
                $provider->fda_registration = $filePath;
            }

            if ($request->hasFile('supplier_questionary_sheet')) {
                unset($filePath);
                $filePath = $request->file('supplier_questionary_sheet')->store('uploads/provider_docs', 'public');
                $provider->supplier_questionary_sheet = $filePath;
            }


            $provider->save();
            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error inserting ' . $provider->provider_name . ': ' . $exception->getMessage());
        }

        return redirect()->route('admin.provider.index')->with('success', $provider->provider_name . ' inserted successfully.');
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
        $data = Provider::where('id', $id)->firstOrFail();

        return view('admin.provider.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     * @throws Throwable
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $provider = Provider::where('id', $id)->firstOrFail();
            $provider->provider_name = $request->input('provider_name');
            $provider->provider_country_name = $request->input('provider_country_name');
            $provider->provider_company_name = $request->input('provider_company_name');
            $provider->provider_physical_address = $request->input('provider_physical_address');
            $provider->provider_pickup_address = $request->input('provider_pickup_address');
            $provider->provider_remit_address = $request->input('provider_remit_address');
            $provider->provider_office_phone = $request->input('provider_office_phone');
            $provider->provider_primary_contact_name = $request->input('provider_primary_contact_name');
            $provider->provider_primary_contact_email = $request->input('provider_primary_contact_email');
            $provider->provider_account_receivable_contact_email = $request->input('provider_account_receivable_contact_email');
            $provider->provider_food_safety_contact_email = $request->input('provider_food_safety_contact_email');
            $provider->provider_food_safety_contact_phone = $request->input('provider_food_safety_contact_phone');
            $provider->provider_emergency_recall_contact_phone = $request->input('provider_emergency_recall_contact_phone');
            $provider->provider_emergency_recall_contact_email = $request->input('provider_emergency_recall_contact_email');
            $provider->provider_list_of_products = $request->input('provider_list_of_products');
            $provider->gfsi_processing_plant_certification_type = $request->input('gfsi_processing_plant_certification_type');

            if ($request->hasFile('gfsi_processing_plant_certification_file')) {
                unset($filePath);
                $filePath = $request->file('gfsi_processing_plant_certification_file')->store('uploads/provider_docs', 'public');
                $provider->gfsi_processing_plant_certification_file = $filePath;
            }

            if ($request->hasFile('social_certification_smeta')) {
                unset($filePath);
                $filePath = $request->file('social_certification_smeta')->store('uploads/provider_docs', 'public');
                $provider->social_certification_smeta = $filePath;
            }

            if ($request->hasFile('fda_registration')) {
                unset($filePath);
                $filePath = $request->file('fda_registration')->store('uploads/provider_docs', 'public');
                $provider->fda_registration = $filePath;
            }

            if ($request->hasFile('supplier_questionary_sheet')) {
                unset($filePath);
                $filePath = $request->file('supplier_questionary_sheet')->store('uploads/provider_docs', 'public');
                $provider->supplier_questionary_sheet = $filePath;
            }

            $provider->save();
            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error updating data: ' . $exception->getMessage());
        }

        return redirect()->route('admin.provider.index')->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Provider::where('id', $id)->firstOrFail()->delete();
        } catch (Exception $exception){
            return response(array('code' => 403, 'status' => 'failed', 'message' => $exception->getMessage()), 403, array('Content-Type' => 'application/json'));
        }

        return response(array('code' => 200,
            'status' => 'success',
            'message' => 'Provider deleted successfully!',
        ), 200, array('Content-Type' => 'application/json'));
    }
}
