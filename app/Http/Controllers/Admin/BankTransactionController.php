<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\BankTransaction;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class BankTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BankAccountDataTable $dataTable)
    {
        return view('admin.transactions.index', compact('data'));
    }

    public function report(string $type, string $id)
    {
        $data2 = [];
        if($type == 'bank'){
            $data = BankTransaction::select('*', 'bank_transactions.id AS bank_transaction_id')
                ->leftJoin('accounts', 'accounts.id', 'bank_transactions.accounts_id')
                ->leftJoin('bank_accounts', 'bank_accounts.id', 'bank_transactions.bank_account_id')
                ->orderBy('bank_transactions.transaction_date', 'ASC')->where('bank_transactions.bank_account_id', $id)->get();
        }
        else if($type == 'account'){
            $data = BankTransaction::select('*', 'bank_transactions.id AS bank_transaction_id')
                ->leftJoin('accounts', 'accounts.id', 'bank_transactions.accounts_id')
                ->leftJoin('bank_accounts', 'bank_accounts.id', 'bank_transactions.bank_account_id')
                ->orderBy('bank_transactions.transaction_date', 'ASC')->where('bank_transactions.accounts_id', $id)->where('bank_currency', 'USD')->get();

            $data2 = BankTransaction::select('*', 'bank_transactions.id AS bank_transaction_id')
                ->leftJoin('accounts', 'accounts.id', 'bank_transactions.accounts_id')
                ->leftJoin('bank_accounts', 'bank_accounts.id', 'bank_transactions.bank_account_id')
                ->orderBy('bank_transactions.transaction_date', 'ASC')->where('bank_transactions.accounts_id', $id)->where('bank_currency', 'JPY')->get();
        }
        else if($type == 'search'){

            $data = BankTransaction::select('*', 'bank_transactions.id AS bank_transaction_id')
                ->leftJoin('accounts', 'accounts.id', 'bank_transactions.accounts_id')
                ->leftJoin('bank_accounts', 'bank_accounts.id', 'bank_transactions.bank_account_id')
                ->orderBy('bank_transactions.transaction_date', 'ASC');

            if(isset($_POST['date_from'])){
                if(!empty($_POST['date_from'])){
                    $data = $data->where('bank_transactions.transaction_date', '>=',  $_POST['date_from']);
                }
            }
            if(isset($_POST['date_to'])){
                if(!empty($_POST['date_to'])){
                    $data = $data->where('bank_transactions.transaction_date', '<=', $_POST['date_to']);
                }
            }
            if(isset($_POST['bank_id'])){
                if(!empty($_POST['bank_id'])){
                    $data = $data->where('bank_transactions.bank_account_id', $_POST['bank_id']);
                }
            }
            if(isset($_POST['account_id'])){
                if(!empty($_POST['account_id'])){
                    $data = $data->where('bank_transactions.accounts_id', $_POST['account_id']);
                }
            }
            $data = $data->where('bank_currency', 'USD')->get();

            $data2 = BankTransaction::select('*', 'bank_transactions.id AS bank_transaction_id')
                ->leftJoin('accounts', 'accounts.id', 'bank_transactions.accounts_id')
                ->leftJoin('bank_accounts', 'bank_accounts.id', 'bank_transactions.bank_account_id')
                ->orderBy('bank_transactions.transaction_date', 'ASC');

            if(isset($_POST['date_from'])){
                if(!empty($_POST['date_from'])){
                    $data2 = $data2->where('bank_transactions.transaction_date', '>=',  $_POST['date_from']);
                }
            }
            if(isset($_POST['date_to'])){
                if(!empty($_POST['date_to'])){
                    $data2 = $data2->where('bank_transactions.transaction_date', '<=', $_POST['date_to']);
                }
            }
            if(isset($_POST['bank_id'])){
                if(!empty($_POST['bank_id'])){
                    $data2 = $data2->where('bank_transactions.bank_account_id', $_POST['bank_id']);
                }
            }
            if(isset($_POST['account_id'])){
                if(!empty($_POST['account_id'])){
                    $data2 = $data2->where('bank_transactions.accounts_id', $_POST['account_id']);
                }
            }
            $data2 = $data2->where('bank_currency', 'JPY')->get();


        }

        return view('admin.transactions.report', compact('data', 'data2', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'bank_id' => 'required|integer',
            'transaction_date' => 'required|date',
            'account_id' => 'required|integer',
            'type' => 'required|string',
            'transaction_amount' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $row = new BankTransaction();
            $row->bank_account_id = $request->input('bank_id');
            $row->accounts_id = $request->input('account_id');
            $row->transaction_date = $request->input('transaction_date');
            $row->type = $request->input('type');
            $row->reference = $request->input('reference');
            $row->transaction_pdf  = $request->input('transaction_pdf');
            $row->transaction_amount = $request->input('transaction_amount');
            $row->bank_charges = $request->input('bank_charges');
            $row->final_amount = $request->input('final_amount');
            $row->ex_rate = $request->input('ex_rate');
            $row->usd_amount = $request->input('usd_amount');

            if ($request->hasFile('transaction_pdf')) {
                unset($filePath);
                $filePath = $request->file('transaction_pdf')->store('uploads/bank', 'public');
                $row->transaction_pdf = $filePath;
            }
            $row->save();
            DB::commit();


        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error inserting' . $exception->getMessage());
        }
        return redirect()->route('admin.transactions.create')->with('success', 'inserted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BankTransaction $bankTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = BankTransaction::where('id', $id)->firstOrFail();

        return view('admin.transactions.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $row = BankTransaction::where('id', $id)->firstOrFail();
            $row->bank_account_id = $request->input('bank_id');
            $row->accounts_id = $request->input('account_id');
            $row->transaction_date = $request->input('transaction_date');
            $row->type = $request->input('type');
            $row->reference = $request->input('reference');
            $row->transaction_pdf  = $request->input('transaction_pdf');
            $row->transaction_amount = $request->input('transaction_amount');
            $row->bank_charges = $request->input('bank_charges');
            $row->final_amount = $request->input('final_amount');
            $row->ex_rate = $request->input('ex_rate');
            $row->usd_amount = $request->input('usd_amount');

            if ($request->hasFile('transaction_pdf')) {
                unset($filePath);
                $filePath = $request->file('transaction_pdf')->store('uploads/bank', 'public');
                $row->transaction_pdf = $filePath;
            }
            $row->save();
            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'error updating data: ' . $exception->getMessage());
        }
        return redirect()->back()->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            BankTransaction::where('id', $id)->firstOrFail()->delete();
        } catch (Exception $exception){
            return response(array('code' => 403, 'status' => 'failed', 'message' => $exception->getMessage()), 403, array('Content-Type' => 'application/json'));
        }

        return response(array('code' => 200,
            'status' => 'success',
            'message' => 'Transaction deleted successfully!',
        ), 200, array('Content-Type' => 'application/json'));
    }
}
