<?php

namespace App\DataTables;

use App\Models\Slider;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SliderDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query) {
                $edit_btn = "<a href='" . route('admin.slider.edit', $query->id) . "' class='btn btn-primary mr-2'><i class='fas fa-edit'></i></a>";
                $delete_btn = "<a href='" . route('admin.slider.destroy', $query->id) . "' class='btn btn-danger delete-item'><i class='fas fa-trash'></i></a>";

                return $edit_btn . $delete_btn;
            })
            ->addColumn('banner', function ($query) {
                return "<img src='" . asset($query->banner) . "' alt='' style='width: 100px;'>";
            })
            ->addColumn('status', function ($query) {
                $active = '<i class="badge badge-success">Active</i>';
                $in_active = '<i class="badge badge-danger">Inactive</i>';

                if ($query->status == 1) {
                    return $active;
                } else {
                    return $in_active;
                }
            })
            ->rawColumns(['action', 'banner', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Slider $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('slider-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(0)
            ->selectStyleSingle()
            ->buttons([
                // Button::make('excel'),
                // Button::make('csv'),
                // Button::make('pdf'),
                // Button::make('print'),
                // Button::make('reset'),
                // Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->width(100)->addClass('text-left'),
            Column::make('banner')->width(200),
            Column::make('title'),
            Column::make('serial')->addClass('text-left'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(200)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Slider_' . date('YmdHis');
    }
}