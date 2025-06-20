<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AccountsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Accounts;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AccountsDataTable $dataTable)
    {
        return $dataTable->render('admin.accounts.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     * @throws Throwable
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'account_name' => 'required|string|max:255'
        ]);

        DB::beginTransaction();

        try {
            $row = new Accounts();
            $row->account_name = $request->input('account_name');
            $row->account_type = $request->input('account_type');
            $row->save();
            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error inserting ' . $row->account_name . ': ' . $exception->getMessage());
        }

        return redirect()->route('admin.accounts.index')->with('success', $row->account_name . ' inserted successfully.');
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
        $data = Accounts::where('id', $id)->firstOrFail();

        return view('admin.accounts.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     * @throws Throwable
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $row = Accounts::where('id', $id)->firstOrFail();
            $row->account_name = $request->input('account_name');
            $row->account_type = $request->input('account_type');
            $row->save();
            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error updating data: ' . $exception->getMessage());
        }

        return redirect()->route('admin.accounts.index')->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Accounts::where('id', $id)->firstOrFail()->delete();
        } catch (Exception $exception){
            return response(array('code' => 403, 'status' => 'failed', 'message' => $exception->getMessage()), 403, array('Content-Type' => 'application/json'));
        }

        return response(array('code' => 200,
            'status' => 'success',
            'message' => 'Account Title deleted successfully!',
        ), 200, array('Content-Type' => 'application/json'));
    }
}
