<?php

namespace App\DataTables;

use App\Models\BankAccount;
use App\Models\BankTransaction;
use App\Utils\ColorUtils;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BankAccountDataTable extends DataTable
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
                return '<a target="_blank" href="'. route('admin.transactions.report', ['bank', $query->id]) .'" class="btn btn-sm font-sm rounded btn-facebook">
                    <i class="material-icons md-visibility fs-6"></i> Statement
                </a>';
            })
            ->addColumn('balance', function ($query) {
                $balance=0;
                $bank_currency = '';
                $transactions = BankTransaction::select('bank_transactions.type', 'bank_transactions.final_amount', 'bank_accounts.bank_currency')
                    ->leftJoin('bank_accounts', 'bank_accounts.id', 'bank_transactions.bank_account_id')
                    ->where('bank_account_id', $query->id)->get()->toArray();
                foreach($transactions as $t) {
                    if($t['type']=='DR') {
                        $balance += $t['final_amount'];
                    }elseif($t['type']=='DR') {
                        $balance -= $t['final_amount'];
                    }
                    $bank_currency = $t['bank_currency'];
                }
                return '<span class="float-start">'.$bank_currency. '</span>'. number_format($balance,0);
            })
            ->addColumn('action', function ($query) {
                return '<a href="'. route('admin.bank.edit', $query->id) .'" class="btn btn-sm font-sm rounded btn-dark">
                    <i class="material-icons md-edit fs-6"></i>
                </a>
                <a href="'. route('admin.bank.destroy', $query->id) .'" class="btn btn-sm delete-part-category font-sm rounded btn-danger">
                    <i class="material-icons md-delete_forever fs-6"></i>
                </a>';

            })
            ->rawColumns(['balance', 'view', 'action']);
    }



    /**
     * Get the query source of dataTable.
     */
    public function query(BankAccount $model): QueryBuilder
    {
        return $query = $model->newQuery()->orderBy('bank_currency', 'ASC');

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
                    ->action("window.location = '".route('admin.bank.create')."';")
                    ->text('<i class="fas fa-plus"></i> Create New Bank Account'),
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
            Column::make('bank_account_title')->title('Account Title')->className('text-start')->width(120),
            Column::make('bank_account_no')->title('Account No.')->className('text-start')->width(120),
            Column::make('bank_name')->className('text-start')->width(120),
            Column::make('bank_branch')->className('text-start')->width(120),
            Column::make('bank_country')->title('Country')->className('text-start')->width(90),
            Column::make('bank_currency')->title('Currency')->className('text-start')->width(40),
            Column::make('bank_details')->title('Description / Comments')->className('text-start')->width(220),
            Column::make('balance')->title('Balance')->className('text-end')->width(110),
            Column::make('view')->className('text-center')->width(140),
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
        return 'Bank_Accounts_' . date('YmdHis');
    }
}




