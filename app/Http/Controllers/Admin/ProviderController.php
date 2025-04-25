<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProvidersDataTable;
use App\Http\Controllers\Controller;
use App\Models\Provider;
use Exception;
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

    /**
     * Store a newly created resource in storage.
     * @throws Throwable
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'provider_name' => 'required|string|max:255',
            'provider_description' => 'max:255',
            'provider_address' => 'max:255'
        ]);

        DB::beginTransaction();

        try {
            $Provider = new Provider();
            $Provider->Provider_name = $request->input('provider_name');
            $Provider->Provider_description = $request->input('provider_description');
            $Provider->Provider_address = $request->input('provider_address');

            $Provider->save();
            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error inserting ' . $Provider->provider_name . ': ' . $exception->getMessage());
        }

        return redirect()->route('admin.provider.index')->with('success', $Provider->provider_name . ' inserted successfully.');
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
            $Name = Provider::where('id', $id)->firstOrFail();
            $Name->provider_name = strtoupper($request->input('provider_name'));
            $Name->provider_description = $request->input('provider_description');
            $Name->provider_address = $request->input('provider_address');

            $Name->save();
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
