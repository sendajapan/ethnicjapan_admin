<?php

namespace App\DataTables;

use App\Models\Provider;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProvidersDataTable extends DataTable
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
                return $query->provider_name.'<a href="'. route('admin.provider.edit', $query->id) .'" class="float-end btn btn-sm font-sm rounded btn-dark">
                    <i class="material-icons md-edit fs-6"></i> Edit
                </a>';
            })
            ->addColumn('action', function ($query) {
                return '<a href="'. route('admin.provider.destroy', $query->id) .'" class="btn btn-sm delete-part-category font-sm rounded btn-danger">
                    <i class="material-icons md-delete_forever fs-6"></i>
                </a>';
            })
            ->addColumn('provider_list_of_products', function ($query) {
                return nl2br($query->provider_list_of_products);
            })



            ->addColumn('detail', function ($query) {
                return '<a target="_blank" href="'. route('admin.provider.detail', $query->id) .'" class="btn btn-sm font-sm rounded btn-facebook">
                    <i class="material-icons md-visibility fs-6"></i> View
                </a>';
            })
            ->rawColumns([  'provider_name', 'provider_list_of_products','category_name', 'category_description', 'detail', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Provider $model): QueryBuilder
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
            ->setTableId('providers-table')
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
                    ->action("window.location = '".route('admin.provider.create')."';")
                    ->text('<i class="fas fa-plus"></i> Create New Provider'),
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
            Column::make('provider_name')->className('text-start')->width(140),
            Column::make('provider_country_name')->className('text-start')->width(340),
            Column::make('provider_physical_address')->className('text-start')->width(200),
            Column::make('provider_list_of_products')->className('text-start')->width(200),
            Column::make('detail')->className('text-center')->width(60),
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
        return 'Providers_' . date('YmdHis');
    }
}
