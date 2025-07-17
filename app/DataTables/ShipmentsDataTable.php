<?php

namespace App\DataTables;

use App\Models\Shipment;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ShipmentsDataTable extends DataTable
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
            ->addColumn('provider_name', function ($query) {
                return $query->provider->provider_name;
            })
            ->addColumn('action', function ($query) {
                return '<div class="d-flex flex-column gap-2 align-items-center">
                            <a target="_blank" href="'. route('admin.purchase.detail', $query->id) .'" class="btn btn-sm font-sm rounded btn-facebook"><i class="material-icons md-visibility fs-6 me-2"></i>View</a>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="' . route('admin.purchase.edit', $query->id) . '" class="btn btn-sm font-sm rounded btn-dark flex-fill"><i class="material-icons md-edit fs-6 me-2"></i>Edit</a>
                                <a href="' . route('admin.purchase.destroy', $query->id) . '" class="btn btn-sm delete-part-category font-sm rounded btn-danger flex-fill"><i class="material-icons md-delete_forever fs-6 me-2"></i>Delete</a>
                            </div>
                        </div>';

            })
            ->rawColumns(['provider_name', 'invoice_date', 'invoice_number', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Shipment $model): QueryBuilder
    {
        return $query = $model->newQuery()->with('provider');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $disablePagination = $this->disablePagination ?? false;

        return $this->builder()
            ->setTableId('purchases-table')
            ->addTableClass("table table-striped table-light table-border table-hover align-middle table-nowrap mb-0")
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
                    ->action("window.location = '".route('admin.purchase.create')."';")
                    ->text('<i class="fas fa-plus"></i> Register New Purchase'),
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
            Column::make('provider_name')->className('text-start')->width(90),

            Column::make('invoice_number')->title('Invoice Number')->className('text-start')->width(90),
            Column::make('invoice_date')->title('Invoice Date')->className('text-start')->width(90),
            Column::make('port_of_loading')->title('Port of Loading')->className('text-start')->width(90),
            Column::make('port_of_landing')->title('Port of Landing')->className('text-start')->width(90),
            Column::make('incoterm')->title('Incoterm')->className('text-start')->width(90),
            Column::make('bl_number')->title('Bl number')->className('text-start')->width(90),
            Column::make('shipping_line')->title('Shipping Line')->className('text-start')->width(90),
            Column::make('vessel')->title('Vessel')->className('text-start')->width(90),
            Column::make('eta')->title('ETA')->className('text-start')->width(90),
            Column::make('etd')->title('ETD')->className('text-start')->width(90),

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
        return 'Purchases_' . date('YmdHis');
    }
}
