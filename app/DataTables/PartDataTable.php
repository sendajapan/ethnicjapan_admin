<?php

namespace App\DataTables;

namespace App\DataTables;

use App\Models\Part;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PartDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('part_category_name', function ($query) {
                return '<a class="text-black px-2 fw-bold rounded-2" href="#" style="font-size: 11px; padding-block: 2px">' . $query->part_category_name . '</a>';
            })
            ->addColumn('make', function ($query) {
                return '<div>
                            <img class=""  alt="" src=""/>
                            <a class="text-black px-2 fw-bold rounded-2" href="#" style="font-size: 11px; padding-block: 2px">' . $query->make . '</a>
                        </div>';
            })
            ->filterColumn('part_category_name', fn($query, $keyword) => $query->whereRaw('LOWER(part_categories.name) LIKE ?', ["%{$keyword}%"]))
            ->filterColumn('make', fn($query, $keyword) => $query->whereRaw('LOWER(vehicles.make_title) LIKE ?', ["%{$keyword}%"]))
            ->filterColumn('model', fn($query, $keyword) => $query->whereRaw('LOWER(vehicles.model_title) LIKE ?', ["%{$keyword}%"]))
            ->addColumn('action', function ($query) {
                return '<a href="#"
                        class="open-modal"
                        data-bs-toggle="modal"
                        data-bs-target="#partsModal"
                        data-make_id="' . $query->make_id . '"
                        data-model_id="' . $query->model_id . '"
                        data-part_category_id="' . $query->part_category_id . '">
                        view
                    </a>';
            })
            ->rawColumns(['part_category_name', 'make', 'action']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @param Part $model
     * @return QueryBuilder
     */
    public function query(Part $model): QueryBuilder
    {
        $selectColumns = [
            'ROW_NUMBER() OVER (ORDER BY part_categories.name, vehicles.make_title) AS serial_number',
            'vehicles.make_id as make_id',
            'vehicles.model_id as model_id',
            'SUM(parts.quantity) as total_quantity',
            'ROUND(AVG(parts.price)) as unit_avg_price',
            'part_categories.id as part_category_id',
            'part_categories.name as part_category_name',
            'vehicles.make_title as make',
            'vehicles.model_title as model'
        ];

        $query = $model->newQuery()
            ->selectRaw(implode(', ', $selectColumns))
            ->join('part_categories', 'parts.part_category_id', '=', 'part_categories.id')
            ->join('vehicles', 'parts.vehicle_id', '=', 'vehicles.id')
            ->groupBy(
                'vehicles.make_id',
                'vehicles.model_id',
                'vehicles.make_title',
                'vehicles.model_title',
                'part_categories.name',
                'parts.price'
            );

        $this->applyFilters($query);

        return $query;
    }

    /**
     * Apply filters to the query based on the request.
     *
     * @param QueryBuilder $query
     */
    protected function applyFilters(QueryBuilder $query): void
    {
        if ($makes = request()->get('make')) {
            $query->whereIn('vehicles.make_id', $makes);
        }

        if ($models = request()->get('model')) {
            $query->whereIn('vehicles.model_id', $models);
        }

        if ($parts = request()->get('part')) {
            $query->whereIn('parts.part_category_id', $parts);
        }
    }

    /**
     * Optional method if you want to use the html builder.
     *
     * @return HtmlBuilder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('part-table')
            ->addTableClass('table-striped border-muted border-1')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1, 'DESC')
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
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('serial_number')
                ->width(40)
                ->title('S/N')
                ->className('font-weight-bold text-center')
                ->searchable(false),
            Column::make('part_category_name')
                ->title('Part Name')
                ->className('text-start'),
            Column::make('make')
                ->className('text-start uppercase'),
            Column::make('model')
                ->className('text-start capitalize'),
            Column::make('total_quantity')
                ->title('Qty')
                ->className('text-end')
                ->searchable(false),
            Column::make('unit_avg_price')
                ->title('Avg Price')
                ->className('text-end')
                ->searchable(false),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(80)
                ->addClass('text-center')
        ];
    }

    /**
     * Get the filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        $filters = request()->only('make', 'model', 'part');
        $filterString = implode('_', $filters);
        return 'Part_' . $filterString . '_' . date('YmdHis');
    }
}
