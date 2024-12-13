<?php

namespace App\DataTables;

use App\Models\ProductVariantItem;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductVariantItemDataTable extends DataTable
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
                $editBtn = '<a href="' . route("admin.products-variant-item.edit", $query->id) . '" class="btn btn-primary mr-2"><i class="fas fa-edit"></i></a>';
                $deleteBtn = '<a href="' . route("admin.products-variant-item.destroy", $query->id) . '" class="btn btn-danger mr-1 delete-item"><i class="fas fa-trash"></i></a>';

                return $editBtn . $deleteBtn;
            })
            ->addColumn('variant_name', function ($query) {
                return $query->productVariant->name;
            })
            ->addColumn('is_default', function ($query) {
                if ($query->is_default == 1) {
                    return '<i class="badge badge-success">Default</i>';
                } else {
                    return '<i class="badge badge-danger">No</i>';
                }
            })
            ->addColumn('status', function ($query) {
                $checked = $query->status == 1 ? 'checked' : '';

                return '<label class="custom-switch mt-2">
                        <input type="checkbox" ' . $checked . ' name="custom-switch-checkbox" data-id="' . $query->id . '" class="custom-switch-input change-status">
                        <span class="custom-switch-indicator"></span>
                      </label>';
            })
            ->rawColumns(['action', 'variant_name', 'status', 'is_default'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductVariantItem $model): QueryBuilder
    {
        return $model
            ->where('product_variant_id', request()->variant_id)
            ->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('productvariantitem-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(0)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload'),
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->width(100)->addClass('text-left'),
            Column::make('name'),
            Column::make('variant_name'),
            Column::make('price')->width(150)->addClass('text-center'),
            Column::make('is_default')->width(200),
            Column::make('status')->width(150),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ProductVariantItem_' . date('YmdHis');
    }
}
