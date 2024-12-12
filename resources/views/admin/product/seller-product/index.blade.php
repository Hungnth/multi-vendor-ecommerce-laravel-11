@extends('admin.layouts.master')

@section('content')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Sellers Product</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Seller Products</h4>
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
                    url: "{{ route('admin.product.change-status') }}",
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

            // Change approved status
            $('body').on('change', '.is_approved', function () {
                let value = $(this).val();
                let id = $(this).data('id');

                $.ajax({
                    url: "{{ route('admin.change-approve-status') }}",
                    method: 'PUT',
                    data: {
                        value: value,
                        id: id
                    },
                    success: function (data) {
                        flasher.success(data.message);
                        window.location.reload()
                    },
                    error: function (xhr, status, error) {
                        flasher.error(error);
                    }
                })
            });
        })
    </script>
@endpush
