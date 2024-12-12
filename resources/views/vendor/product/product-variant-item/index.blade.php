@extends('vendor.layouts.master')

@push('css')
@endpush

@section('content')
    <section id="wsus__dashboard">
        <div class="container-fluid">
            @include('vendor.layouts.sidebar')

            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <a href="{{ route('vendor.products-variant.index', ['product' => $product->id]) }}" class="btn btn-warning mb-4"><i
                            class="fas fa-arrow-left"></i> Back</a>
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="fas fa-box"></i> Product Variant Item</h3>
                        <h6>Variant: {{ $variant->name }}</h6>
                        <div class="create_btn">
                            <a href="{{ route('vendor.products-variant-item.create', ['product_id' => $product->id, 'variant_id' => $variant->id]) }}" class="btn btn-primary"><i class="fas fa-plus"></i> Create Variant Item</a>
                        </div>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                {{ $dataTable->table() }}
                            </div>
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
                    url: "{{ route('vendor.products-variant-item.change_status') }}",
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
