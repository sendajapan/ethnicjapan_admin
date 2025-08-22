<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CustomersDataTable;
use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\Customer;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(CustomersDataTable $dataTable)
    {
        return $dataTable->render('admin.customer.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     * @throws Throwable
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_description' => 'max:255',
            'customer_address' => 'max:255'
        ]);

        DB::beginTransaction();

        try {
            $row = new Accounts();
            $row->account_name = $request->input('customer_name');
            $row->account_type = 'Customer';
            $row->save();
            $row_insert_id = $row->id;

            $customer = new Customer();
            $customer->customer_name = $request->input('customer_name');
            $customer->customer_country_name = $request->input('customer_country_name');
            $customer->customer_office_phone = $request->input('customer_office_phone');
            $customer->customer_primary_contact_name = $request->input('customer_primary_contact_name');
            $customer->customer_primary_contact_email = $request->input('customer_primary_contact_email');
            $customer->customer_address = $request->input('customer_address');
            $customer->customer_description = $request->input('customer_description');
            $customer->account_id = $row_insert_id;

            $customer->save();




            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error inserting ' . $customer->customer_name . ': ' . $exception->getMessage());
        }

        return redirect()->route('admin.customer.index')->with('success', $customer->customer_name . ' inserted successfully.');
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
        $data = Customer::where('id', $id)->firstOrFail();

        return view('admin.customer.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     * @throws Throwable
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $customer = Customer::where('id', $id)->firstOrFail();
            $customer->customer_name = $request->input('customer_name');
            $customer->customer_country_name = $request->input('customer_country_name');
            $customer->customer_office_phone = $request->input('customer_office_phone');
            $customer->customer_primary_contact_name = $request->input('customer_primary_contact_name');
            $customer->customer_primary_contact_email = $request->input('customer_primary_contact_email');
            $customer->customer_address = $request->input('customer_address');
            $customer->customer_description = $request->input('customer_description');

            $customer->save();
            
            // Update corresponding account record
            if($customer->account_id) {
                $account = Accounts::where('id', $customer->account_id)->first();
                if($account) {
                    $account->account_name = $request->input('customer_name');
                    $account->save();
                }
            }
            
            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error updating data: ' . $exception->getMessage());
        }

        return redirect()->route('admin.customer.index')->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Customer::where('id', $id)->firstOrFail()->delete();
                        // Delete corresponding account record
            $account = Accounts::where('id', $id)->first();
            if($account) {
                $account->delete();
            }
        } catch (Exception $exception){
            return response(array('code' => 403, 'status' => 'failed', 'message' => $exception->getMessage()), 403, array('Content-Type' => 'application/json'));
        }

        return response(array('code' => 200,
            'status' => 'success',
            'message' => 'Customer deleted successfully!',
        ), 200, array('Content-Type' => 'application/json'));
    }
}
