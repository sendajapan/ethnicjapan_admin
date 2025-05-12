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
                if ($query->purchase_invoice != '') {
                    return '<a target="_blank" href="' . url('/' . $query->purchase_invoice) . '" class="btn btn-youtube font-sm btn-outline-danger">
                    <i class="material-icons md-picture_as_pdf fs-6"></i>
                </a>';
                }
                return '';
            })
            ->addColumn('provider_name', function ($query) {
                return $query->provider->provider_name;
            })
            ->addColumn('purchase_amount', function ($query) {
                return "$ ".number_format($query->purchase_amount,2);
            })
            ->addColumn('product_qty', function ($query) {
                $item_count = $query->purchasedItems->count();
                $html = $item_count;
                if($item_count>0){
                    $html .= '
                    <a id="detail_link_show_'.$query->id.'" class="show_detail_table_link float-end" onclick="show_detail('.$query->id.')">Show Details</a>
                    <a id="detail_link_hide_'.$query->id.'" class="float-end" onclick="show_detail('.$query->id.')" style="display: none;">Hide Details</a>
                    <table id="detail_table_'.$query->id.'" width="100%" class="table table-nowrap mb-0 " style="line-height:0; font-size:10px; display:none;">
                        <tr>
                            <td class="fw-bolder bg-black text-white">No.</td>
                            <td class="fw-bolder bg-black text-white">Item</td>
                            <td class="fw-bolder bg-black text-white">Qty</td>
                            <td class="fw-bolder bg-black text-white">Unit<br>Price</td>
                            <td class="fw-bolder bg-black text-white">Amount</td>
                        </tr>';

                        foreach($query->purchasedItems as $key => $item){
                        $html .= '<tr>
                            <td class="text-left">'.($key+1).'</td>
                            <td class="text-left">'.$item->item->item_name.'</td>
                            <td class="text-center">'.number_format($item->item_qty,0).'</td>
                            <td class="text-end">'.number_format($item->item_unit_price,2).'</td>
                            <td class="text-end">'.number_format($item->item_line_price,2).'</td>
                        </tr>';
                        }

                        $html .= '<tr>
                            <td class="fw-bolder" colspan="4">Total</td>
                            <td class="fw-bolder text-end">'.number_format($query->purchase_amount,2).'</td>
                        </tr>
                    </table>';
                }
                return $html;
            })
            ->addColumn('action', function ($query) {
                return '<a href="' . route('admin.purchase.edit', $query->id) . '" class="btn btn-sm font-sm rounded btn-dark">
                    <i class="material-icons md-edit fs-6"></i>
                </a>
                <a href="' . route('admin.purchase.destroy', $query->id) . '" class="btn btn-sm delete-part-category font-sm rounded btn-danger">
                    <i class="material-icons md-delete_forever fs-6"></i>
                </a>';

            })
            ->rawColumns(['purchase_no', 'provider_name', 'purchase_date', 'product_qty', 'purchase_amount', 'purchase_invoice', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Purchase $model): QueryBuilder
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
                    ->action("window.location = '".route('admin.purchase.create')."';")
                    ->text('<i class="fas fa-plus"></i> Regsiter New Purchase'),
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
            Column::make('purchase_no')->className('text-start')->width(140),
            Column::make('provider_name')->className('text-start')->width(140),
            Column::make('purchase_date')->className('text-start')->width(140),
            Column::make('product_qty')->className('text-start')->width(290),
            Column::make('purchase_amount')->className('text-center')->width(90),
            Column::make('purchase_invoice')->className('text-start')->width(90),
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
