<?php

namespace App\DataTables;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CustomersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('DT_RowIndex')
            ->addIndexColumn()
            ->addColumn('action', function ($query) {
                return '<a href="'. route('admin.customer.edit', $query->id) .'" class="btn btn-sm font-sm rounded btn-dark">
                    <i class="material-icons md-edit fs-6"></i>
                </a>
                <a href="'. route('admin.customer.destroy', $query->id) .'" class="btn btn-sm delete-part-category font-sm rounded btn-danger">
                    <i class="material-icons md-delete_forever fs-6"></i>
                </a>';

            })
            ->rawColumns([  'customer_name', 'customer_description', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Customer $model): QueryBuilder
    {
        return $query = $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $disablePagination = $this->disablePagination ?? false;

        return $this->builder()
            ->setTableId('customers-table')
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
                    ->action("window.location = '".route('admin.customer.create')."';")
                    ->text('<i class="fas fa-plus"></i> Create New Customer'),
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
            Column::make('customer_name')->title('Name')->className('text-start')->width(200),
            Column::make('customer_office_phone')->title('Phone')->className('text-start')->width(200),
            Column::make('customer_primary_contact_name')->title('Primary Contact Name')->className('text-start')->width(200),
            Column::make('customer_primary_contact_email')->title('Primary Contact Email')->className('text-start')->width(200),
            Column::make('customer_address')->title('Address')->className('text-start')->width(200),
            Column::make('customer_country_name')->title('Country')->className('text-start')->width(200),
            Column::make('customer_description')->title('Description')->className('text-start')->width(200),



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
        return 'Customers_' . date('YmdHis');
    }
}
