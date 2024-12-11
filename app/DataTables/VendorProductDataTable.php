<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VendorProductDataTable extends DataTable
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
                $edit_btn = '<a href="' . route("vendor.products.edit", $query->id) . '" class="btn btn-primary me-2"><i class="fas fa-edit"></i></a>';
                $delete_btn = '<a href="' . route("vendor.products.destroy", $query->id) . '" class="btn btn-danger me-1 delete-item"><i class="fas fa-trash"></i></a>';
                $more_btn = '<div class="dropdown dropleft d-inline">
                      <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <i class="fas fa-cog"></i>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item has-icon" href="' . route('admin.products-image-gallery.index', ['product' => $query->id]) . '"><i class="fas fa-images"></i> Image Gallery</a>
                        <a class="dropdown-item has-icon" href="' . route('admin.products-variant.index', ['product' => $query->id]) . '"><i class="fas fa-sliders-h"></i> Variants</a>
                      </div>
                    </div>';

                return $edit_btn . $delete_btn . $more_btn;
            })
            ->addColumn('image', function ($query) {
                return "<img src='" . asset($query->thumb_image) . "' alt='' style='width: 70px;'>";
            })
            ->addColumn('type', function ($query) {
                return match ($query->product_type) {
                    'new_arrival' => '<i class="badge bg-success p-2">New Arrival</i>',
                    'featured_product' => '<i class="badge bg-warning p-2">Featured Product</i>',
                    'top_product' => '<i class="badge bg-info p-2">Top Product</i>',
                    'best_product' => '<i class="badge bg-danger p-2">Best Product</i>',
                    default => '<i class="badge bg-dark p-2">None</i>',
                };
            })
            ->addColumn('status', function ($query) {
                $checked = $query->status == 1 ? 'checked' : '';

                return '<div class="form-check form-switch">
                            <input ' . $checked . ' class="form-check-input change-status" type="checkbox" id="change_status" data-id="' . $query->id . '">
                        </div>';
            })
            ->rawColumns(['action', 'image', 'type', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('vendorproduct-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
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
            Column::make('image'),
            Column::make('name'),
            Column::make('price'),
            Column::make('type')->width(200),
            Column::make('status')->width(150),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(250)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'VendorProduct_' . date('YmdHis');
    }
}
