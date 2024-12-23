<?php

namespace App\DataTables;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DeliveredOrderDataTable extends DataTable
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
                $showBtn = "<a href='" . route('admin.orders.show', $query->id) . "' class='btn btn-primary mr-2'><i class='fas fa-eye'></i></a>";
                $deleteBtn = "<a href='" . route('admin.products.destroy', $query->id) . "' class='btn btn-danger mr-2 delete-item'><i class='fas fa-trash'></i></a>";

                return $showBtn . $deleteBtn;
            })
            ->addColumn('customer', function ($query) {
                return $query->user->name;
            })
            ->addColumn('amount', function ($query) {
                return $query->currency_icon . $query->amount;
            })
            ->addColumn('date', function ($query) {
                return date('d-M-Y', strtotime($query->created_at));
            })
            ->addColumn('payment_status', function ($query) {
                if ($query->payment_status === 1) {
                    $badge = 'success';
                    $payment_status = 'Completed';
                } else {
                    $badge = 'warning';
                    $payment_status = 'Pending';
                }
                return "<span class='badge bg-$badge text-white'>$payment_status</span>";
            })
            ->addColumn('order_status', function ($query) {
                return match ($query->order_status) {
                    'pending' => '<span class="badge badge-warning">Pending</span>',
                    'processed_and_ready_to_ship' => '<span class="badge badge-info">Processed</span>',
                    'dropped_off' => '<span class="badge badge-info">Dropped Off</span>',
                    'shipped' => '<span class="badge badge-info">Shipped</span>',
                    'out_for_delivery' => '<span class="badge badge-primary">Out for delivery</span>',
                    'delivered' => '<span class="badge badge-success">Delivered</span>',
                    'canceled' => '<span class="badge badge-danger">Canceled</span>',
                    default => '<span class="badge badge-dark">None</span>',
                };
            })
            ->rawColumns(['action', 'customer', 'date', 'order_status', 'payment_status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Order $model): QueryBuilder
    {
        return $model
            ->where('order_status', 'delivered')
            ->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('pendingorder-table')
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
            Column::make('id')->width(100)->addClass('text-left'),
            Column::make('invoice_id'),
            Column::make('customer'),
            Column::make('date'),
            Column::make('product_qty'),
            Column::make('amount'),
            Column::make('order_status'),
            Column::make('payment_status'),
            Column::make('payment_method'),
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
        return 'PendingOrder_' . date('YmdHis');
    }
}
