@extends('admin.layouts.master')

@section('content')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Product Variant Items</h1>
        </div>
        <div class="mb-3">
            <a href="{{ route('admin.products-variant.index', ['product' => $product->id]) }}" class="btn btn-primary">Back</a>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Variant: {{ $variant->name }}</h4>
                            <div class="card-header-action">
                                <a href="{{ route('admin.products-variant-item.create', ['product_id' => $product->id, 'variant_id' => $variant->id]) }}"
                                   class="btn btn-primary"><i class="fas fa-plus"></i> Create New</a>
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $dataTable->table() }}
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        $(document).ready(function () {
            $('body').on('click', '.change-status', function () {
                let isChecked = $(this).is(':checked');
                let id = $(this).data('id');

                $.ajax({
                    url: "{{ route('admin.products-variant-item.change_status') }}",
                    method: 'PUT',
                    data: {
                        status: isChecked,
                        id: id
                    },
                    success: function (data) {
                        flasher.success(data.message);
                    },
                    error: function (xhr, status, error) {
                        flasher.error(error);
                    }
                })

            });
        })
    </script>
@endpush