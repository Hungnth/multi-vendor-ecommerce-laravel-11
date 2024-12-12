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

class VendorProductVariantItemDataTable extends DataTable
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
                $edit_btn = '<a href="' . route("vendor.products-variant-item.edit", $query->id) . '" class="btn btn-primary me-2"><i class="fas fa-edit"></i></a>';
                $delete_btn = '<a href="' . route("vendor.products-variant-item.destroy", $query->id) . '" class="btn btn-danger me-1 delete-item"><i class="fas fa-trash"></i></a>';

                return $edit_btn . $delete_btn;
            })
            ->addColumn('variant_name', function ($query) {
                return $query->product_variant->name;
            })
            ->addColumn('is_default', function ($query) {
                if ($query->is_default == 1) {
                    return '<i class="badge bg-success p-2">Default</i>';
                } else {
                    return '<i class="badge bg-danger p-2">No</i>';
                }
            })
            ->addColumn('status', function ($query) {
                $checked = $query->status == 1 ? 'checked' : '';

                return '<div class="form-check form-switch">
                            <input ' . $checked . ' class="form-check-input change-status" type="checkbox" id="change_status" data-id="' . $query->id . '">
                        </div>';
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
                    ->setTableId('vendorproductvariantitem-table')
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
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->width(100)->addClass('text-start'),
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
        return 'VendorProductVariantItem_' . date('YmdHis');
    }
}
