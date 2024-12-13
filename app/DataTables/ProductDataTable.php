<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
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
                $editBtn = '<a href="' . route("admin.products.edit", $query->id) . '" class="btn btn-primary mr-2"><i class="fas fa-edit"></i></a>';
                $deleteBtn = '<a href="' . route("admin.products.destroy", $query->id) . '" class="btn btn-danger mr-1 delete-item"><i class="fas fa-trash"></i></a>';
                $moreBtn = '<div class="dropdown dropleft d-inline">
                      <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <i class="fas fa-cog"></i>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item has-icon" href="' . route('admin.products-image-gallery.index', ['product' => $query->id]) . '"><i class="fas fa-images"></i> Image Gallery</a>
                        <a class="dropdown-item has-icon" href="' . route('admin.products-variant.index', ['product' => $query->id]) . '"><i class="fas fa-sliders-h"></i> Variants</a>
                      </div>
                    </div>';

                return $editBtn . $deleteBtn . $moreBtn;
            })
            ->addColumn('image', function ($query) {
                return "<img src='" . asset($query->thumb_image) . "' alt='' style='width: 70px;'>";
            })
            ->addColumn('type', function ($query) {
                return match ($query->product_type) {
                    'new_arrival' => '<i class="badge badge-success">New Arrival</i>',
                    'featured_product' => '<i class="badge badge-warning">Featured Product</i>',
                    'top_product' => '<i class="badge badge-info">Top Product</i>',
                    'best_product' => '<i class="badge badge-danger">Best Product</i>',
                    default => '<i class="badge badge-dark">None</i>',
                };
            })
            ->addColumn('status', function ($query) {
                $checked = $query->status == 1 ? 'checked' : '';

                return '<label class="custom-switch mt-2">
                        <input type="checkbox" ' . $checked . ' name="custom-switch-checkbox" data-id="' . $query->id . '" class="custom-switch-input change-status">
                        <span class="custom-switch-indicator"></span>
                      </label>';
            })
            ->rawColumns(['action', 'image', 'type', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        return $model
            ->where('vendor_id', Auth::user()->vendor->id)
            ->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('product-table')
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
        return 'Product_' . date('YmdHis');
    }
}
