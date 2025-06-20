<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BankAccountDataTable;
use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BankAccountDataTable $dataTable)
    {
        return $dataTable->render('admin.bank.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.bank.create');
    }

    /**
     * Store a newly created resource in storage.
     * @throws Throwable
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'bank_account_title' => 'required|string|max:255',
            'bank_currency' => 'required|string|max:255'
        ]);

        DB::beginTransaction();

        try {
            $row = new BankAccount();
            $row->bank_name = $request->input('bank_name');
            $row->bank_account_no = $request->input('bank_account_no');
            $row->bank_account_title = $request->input('bank_account_title');
            $row->bank_branch = $request->input('bank_branch');
            $row->bank_country = $request->input('bank_country');
            $row->bank_currency = $request->input('bank_currency');
            $row->bank_details = $request->input('bank_details');
            $row->save();
            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error inserting ' . $row->bank_name . ': ' . $exception->getMessage());
        }

        return redirect()->route('admin.bank.index')->with('success', $row->bank_name . ' inserted successfully.');
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
        $data = BankAccount::where('id', $id)->firstOrFail();

        return view('admin.bank.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     * @throws Throwable
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $row = BankAccount::where('id', $id)->firstOrFail();
            $row->bank_name = $request->input('bank_name');
            $row->bank_account_no = $request->input('bank_account_no');
            $row->bank_account_title = $request->input('bank_account_title');
            $row->bank_branch = $request->input('bank_branch');
            $row->bank_country = $request->input('bank_country');
            $row->bank_currency = $request->input('bank_currency');
            $row->bank_details = $request->input('bank_details');
            $row->save();
            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error updating data: ' . $exception->getMessage());
        }

        return redirect()->route('admin.bank.index')->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            BankAccount::where('id', $id)->firstOrFail()->delete();
        } catch (Exception $exception){
            return response(array('code' => 403, 'status' => 'failed', 'message' => $exception->getMessage()), 403, array('Content-Type' => 'application/json'));
        }

        return response(array('code' => 200,
            'status' => 'success',
            'message' => 'Bank Account deleted successfully!',
        ), 200, array('Content-Type' => 'application/json'));
    }
}
