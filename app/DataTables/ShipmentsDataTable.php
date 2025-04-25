<?php

namespace App\DataTables;

use App\Models\Shipment;
use App\Utils\ColorUtils;
use Carbon\Carbon;
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
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->addColumn('departure', function ($query) {
                return $query->departure
                    ? '<strong style="font-size: 12px; font-weight: bold; color: #3BB77E">' . Carbon::parse($query->departure)->format('Y/m/d') . '</strong>'
                    : '<strong class="text-danger" style="font-size: 12px; font-weight: bold;">Not Found</strong>';
            })
            ->addColumn('provider', function ($query) {
                $brandLogo = asset(strtolower($query->provider) === 'karmen' ? '/assets/imgs/brands/karmen-logo.webp' : '/assets/imgs/brands/brand-' . rand(1, 18) . '.jpg');
                return '<div><img src="' . e($brandLogo) . '" alt="' . e($query->provider) . '" style="width: auto; height: 24px; margin-right: 10px; vertical-align: middle;"></div>';
            })
            ->addColumn('shipping_port', function ($query) {
                return '<div class="d-flex align-items-center"><i class="text-body-emphasis material-icons md-anchor" style="width: auto; font-size: 12px; margin-right: 10px; vertical-align: middle;"></i>' . e($query->shipping_port ?? 'Not Found') . '</div>';
            })
            ->addColumn('destination_port', function ($query) {
                return '<div class="d-flex align-items-center"><i class="text-body-emphasis material-icons md-anchor" style="width: auto; font-size: 12px; margin-right: 10px; vertical-align: middle;"></i>' . e($query->destination_port) . '</div>';
            })
            ->addColumn('vehicles', function ($query) {
                return $query->vehicles->count();
            })
            ->addColumn('status', function ($query) {
                return '<span class="badge badge-pill ' . ColorUtils::$badgeClasses[$query->status] . ' font-bold" style="font-size: 11px">' . e($query->status) . '</span>';
            })
            ->addColumn('total_purchase', function ($query) {
                return '<span class="text-success font-bold" style="font-size: 13px">¥' . number_format(e($query->vehicles->sum('purchase_price'))) . '</span>';
            })
            ->addColumn('created_at', function ($query) {
                return '<span class="font-bold">' . Carbon::parse($query->created_at)->format('Y/m/d') . '</span>';
            })
            ->addColumn('updated_at', function ($query) {
                return '<span class="font-bold">' . Carbon::parse($query->updated_at)->format('Y/m/d') . '</span>';
            })
            ->addColumn('action', function ($query) {
                if ($query->status == 'received') {
                    return '<a class="btn btn-xs text-center" href="' . route('admin.shipment.show', $query->id) . '" style="font-size: 12px">View</a>';
                } else {
                    return '<a class="btn btn-warning btn-sm" href="' . route('admin.shipment.receive.request', $query->id) . '" style="font-size: 12px">Receive</a>';
                }
            })
            ->rawColumns(['departure', 'provider', 'shipping_port', 'destination_port', 'status', 'total_purchase', 'created_at', 'updated_at', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Shipment $model): QueryBuilder
    {
        $query = $model->newQuery();

        if ($this->disablePagination) {
            $query->limit($this->limit ?? 10);
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $disablePagination = $this->disablePagination ?? false;

        return $this->builder()
            ->setTableId('shipments-table')
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
            Column::make('id')->className('font-weight-bold text-center'),
            Column::make('departure')->className('text-center')->width(140),
            Column::make('provider'),
            Column::make('shipping_port'),
            Column::make('destination_port'),
            Column::make('vessel'),
            Column::make('vehicles')->width(80)->className('text-center'),
            Column::make('term'),
            Column::make('invoice_customer'),
            Column::make('total_purchase'),
            Column::make('status')
                ->width(100)
                ->addClass('text-center'),
            Column::make('created_at')->className('text-center')->width(140),
            Column::make('updated_at')->className('text-center')->width(140),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(80)
                ->addClass('text-center')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Shipments_' . date('YmdHis');
    }
}
