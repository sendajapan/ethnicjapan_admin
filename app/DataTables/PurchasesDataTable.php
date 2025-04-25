<?php

namespace App\DataTables;

use App\Models\Purchase;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PurchasesDataTable extends DataTable
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
            ->addColumn('purchase_invoice', function ($query) {
                if($query->purchase_invoice!=''){
                    return '<a target="_blank" href="'.url('/'.$query->purchase_invoice).'" class="btn btn-youtube font-sm btn-outline-danger">
                    <i class="material-icons md-picture_as_pdf fs-6"></i>
                </a>';
                }
                else{
                    return '';
                }
            })
            ->addColumn('product_qty', function ($query) {
                return $query->purchasedItems->count();
//                if($query->purchase_invoice!=''){
//                    return '<a target="_blank" href="'.url('/'.$query->purchase_invoice).'" class="btn btn-youtube font-sm btn-outline-danger">
//                    <i class="material-icons md-picture_as_pdf fs-6"></i>
//                </a>';
//                }
//                else{
//                    return '';
//                }
            })
            ->addColumn('action', function ($query) {
                return '<a href="'. route('admin.purchase.edit', $query->id) .'" class="btn btn-sm font-sm rounded btn-dark">
                    <i class="material-icons md-edit fs-6"></i>
                </a>
                <a href="'. route('admin.purchase.destroy', $query->id) .'" class="btn btn-sm delete-part-category font-sm rounded btn-danger">
                    <i class="material-icons md-delete_forever fs-6"></i>
                </a>';

            })
            ->rawColumns([  'purchase_no', 'purchase_date', 'product_qty', 'purchase_amount', 'purchase_invoice', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Purchase $model): QueryBuilder
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
            ->setTableId('purchases-table')
            ->addTableClass("table table-hover align-middle table-nowrap mb-0")
            ->setTableHeadClass("table-light bordered")
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters(
                [
                    'pageLength' => 100,
                    'lengthMenu' => [25, 50, 100, 500],
                    'paging' => !$disablePagination,
                    'searching' => !$disablePagination,
                    'info' => !$disablePagination
                ]
            )
            ->orderBy(0)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')->className('text-start')->title('S/N')->width(20),
            Column::make('purchase_no')->className('text-start')->width(140),
            Column::make('purchase_date')->className('text-start')->width(140),
            Column::make('product_qty')->className('text-start')->width(140),
            Column::make('purchase_amount')->className('text-start')->width(140),
            Column::make('purchase_invoice')->className('text-start')->width(140),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
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
