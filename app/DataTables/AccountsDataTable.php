<?php

namespace App\DataTables;

use App\Models\Accounts;
use App\Models\BankTransaction;
use App\Models\Provider;
use App\Models\Customer;
use App\Models\Shipment;
use App\Models\Lot;
use App\Models\PurchaseCosts;
use App\Models\Sale;
use App\Utils\ColorUtils;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AccountsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('DT_RowIndex')
            ->addIndexColumn()
            ->addColumn('view', function ($query) {
                return '<a target="_blank" href="'. route('admin.transactions.report', ['account', $query->id]) .'" class="btn btn-sm font-sm rounded btn-facebook">
                    <i class="material-icons md-visibility fs-6"></i> Statement
                </a>';
            })
            ->addColumn('balance', function ($query) {
                $balance = 0;
                $bank_currency = 'USD';

                if ($query->source_type == 'account') {
                    // Calculate base balance based on account type
                    if ($query->type == 'Customer') {
                        // Get customer and calculate sales total (what they owe us)
                        $customer = Customer::where('account_id', $query->id)->first();
                        if ($customer) {
                            $balance = Sale::where('customer_id', $customer->id)->sum('sale_amount') ?? 0;
                        }
                    } elseif ($query->type == 'Provider') {
                        // Get provider and calculate shipments total (what we owe them)
                        $provider = Provider::where('account_id', $query->id)->first();
                        if ($provider) {
                            $shipments = Shipment::where('provider_id', $provider->id)->get();
                            foreach($shipments as $shipment) {
                                $lotsTotal = Lot::where('shipment_id', $shipment->id)->sum('total_price') ?? 0;
                                $costsTotal = PurchaseCosts::where('shipment_id', $shipment->id)->sum('cost_amount') ?? 0;
                                $balance -= ($lotsTotal + $costsTotal); // Negative = we owe them
                            }
                        }
                    }
                    
                    // Add bank transactions for all account types to get net balance
                    $transactions = BankTransaction::select('bank_transactions.type', 'bank_transactions.final_amount', 'bank_accounts.bank_currency')
                        ->leftJoin('bank_accounts', 'bank_accounts.id', 'bank_transactions.bank_account_id')
                        ->where('accounts_id', $query->id)->get()->toArray();

                    foreach($transactions as $t) {
                        if($t['type']=='CR') {
                            $balance += $t['final_amount'];
                        }elseif($t['type']=='DR') {
                            $balance -= $t['final_amount'];
                        }
                        $bank_currency = $t['bank_currency'] ?? 'USD';
                    }
                } 
                
                // Format balance with appropriate sign and color
                $formattedBalance = number_format(abs($balance), 0);
                $sign = '';
                $color = '';
                
                if ($query->type == 'Customer' && $balance > 0) {
                    $sign = '+';
                    $color = 'text-success'; // Green for credit
                } elseif ($query->type == 'Provider' && $balance < 0) {
                    $sign = '-';
                    $color = 'text-danger'; // Red for debt
                } elseif ($balance < 0) {
                    $sign = '-';
                    $color = 'text-danger';
                } elseif ($balance > 0) {
                    $sign = '+';
                    $color = 'text-success';
                }
                
                return '<span class="float-start">'.$bank_currency. '</span><span class="'.$color.'">'.$sign. $formattedBalance.'</span>';
            })
            ->addColumn('action', function ($query) {
                if ($query->source_type == 'account') {
                    return '<a href="'. route('admin.accounts.edit', $query->id) .'" class="btn btn-sm font-sm rounded btn-dark">
                        <i class="material-icons md-edit fs-6"></i>
                    </a>';
                } else if ($query->source_type == 'provider') {
                    return '<a href="'. route('admin.provider.edit', $query->id) .'" class="btn btn-sm font-sm rounded btn-dark">
                        <i class="material-icons md-edit fs-6"></i>
                    </a>';
                } else if ($query->source_type == 'customer') {
                    return '<a href="'. route('admin.customer.edit', $query->id) .'" class="btn btn-sm font-sm rounded btn-dark">
                        <i class="material-icons md-edit fs-6"></i>
                    </a>';
                }
            })
            ->rawColumns(['view', 'balance',  'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Accounts $model): QueryBuilder
    {
        $accounts = $model->newQuery()->select(
            'id',
            'account_name as name',
            'account_type as type',
            \DB::raw("'account' as source_type")
        );

        return $accounts;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $disablePagination = $this->disablePagination ?? false;

        return $this->builder()
            ->setTableId('categories-table')
            ->addTableClass("table table-striped table-light table-border table-hover align-middle table-nowrap mb-0 ")
            ->setTableHeadClass("table-light bordered")
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters(
                [
                    'order'=> [[1, 'asc']],
                    'pageLength' => 100,
                    'lengthMenu' => [25, 50, 100, 500],
                    'paging' => !$disablePagination,
                    'searching' => !$disablePagination,
                    'info' => !$disablePagination,
                    'dom' => 'Bfrt<"bottom mt-10 d-flex align-items-center justify-content-between"ip>',
                    'buttons' => ['export', 'print', 'reset', 'reload']
                ]
            )
            ->orderBy(0)
            ->selectStyleSingle()
            ->buttons([
                Button::make('create')
                    ->addClass('btn btn-primary mr-15 mb-15 fs-6 fst-normal bg-success text-white')
                    ->init('function(api, node, config) { $(node).removeClass("dt-button") }')
                    ->action("window.location = '".route('admin.accounts.create')."';")
                    ->text('<i class="fas fa-plus"></i> Create New Account Title'),
                Button::make('excel')->addClass('btn btn-primary btn-facebook mr-15  mb-15 fs-6 fst-normal bg-dark text-white')
                    ->init('function(api, node, config) { $(node).removeClass("dt-button") }')
                    ->text('<i class="fas fa-download"></i> Download Report as Excel'),
                Button::make('print')->addClass('btn btn-primary btn-youtube mr-15  mb-15 fs-6 fst-normal text-white')
                    ->init('function(api, node, config) { $(node).removeClass("dt-button") }')
                    ->text('<i class="fas fa-print"></i> Print Page Data'),
                Button::make('reset')->addClass('btn btn-success btn-primary mr-15  mb-15 fs-6 bg-secondary fst-normal text-white')
                    ->init('function(api, node, config) { $(node).removeClass("dt-button") }')
                    ->text('<i class="fas fa-undo"></i> Reset Page Data')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')->className('text-start')->title('S/N')->width(20),
            Column::make('name')->className('text-start')->width(140)->title('Account Name'),
            Column::make('type')->className('text-start text-capitalize')->width(140)->title('Account Type'),
            Column::make('balance')->title('Balance')->className('text-end')->width(110),
            Column::make('view')->className('text-start')->width(140),
            Column::computed('action')
                ->exportable(true)
                ->printable(true)
                ->width(100)
                ->addClass('text-center')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Accounts_' . date('YmdHis');
    }
}




// <a href="'. route('admin.customer.destroy', $query->id) .'" class="btn btn-sm delete-part-category font-sm rounded btn-danger">
// <i class="material-icons md-delete_forever fs-6"></i>
// </a>
