<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PortsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Ports;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PortsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PortsDataTable $dataTable)
    {
        return $dataTable->render('admin.ports.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.ports.create');
    }

    /**
     * Store a newly created resource in storage.
     * @throws Throwable
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'port_name' => 'required|string|max:255',
            'country_name' => 'required|string|max:255'
        ]);

        DB::beginTransaction();

        try {
            $row = new Ports();
            $row->port_name = $request->input('port_name');
            $row->country_name = $request->input('country_name');
            $row->save();
            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error inserting ' . $row->port_name . ': ' . $exception->getMessage());
        }

        return redirect()->route('admin.ports.index')->with('success', $row->port_name . ' inserted successfully.');
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
        $data = Ports::where('id', $id)->firstOrFail();

        return view('admin.ports.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     * @throws Throwable
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $row = Ports::where('id', $id)->firstOrFail();
            $row->port_name = $request->input('port_name');
            $row->country_name = $request->input('country_name');
            $row->save();
            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error updating data: ' . $exception->getMessage());
        }

        return redirect()->route('admin.ports.index')->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Ports::where('id', $id)->firstOrFail()->delete();
        } catch (Exception $exception){
            return response(array('code' => 403, 'status' => 'failed', 'message' => $exception->getMessage()), 403, array('Content-Type' => 'application/json'));
        }

        return response(array('code' => 200,
            'status' => 'success',
            'message' => 'Port removed successfully!',
        ), 200, array('Content-Type' => 'application/json'));
    }
}
