@extends('admin.layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/bootstrap-daterangepicker/daterangepicker.css') }}">
@endpush

@section('content')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Shipping Rule</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create Shipping Rule</h4>

                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.shipping-rule.store') }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                </div>

                                <div class="form-group">
                                    <label for="inputState">Type</label>
                                    <select id="" class="form-control shipping-type" name="type">
                                        <option value="flat_cost">Flat Cost</option>
                                        <option value="min_cost">Minimum Order Amount</option>
                                    </select>
                                </div>

                                <div class="form-group min_cost d-none">
                                    <label>Minimum Amount</label>
                                    <input type="text" class="form-control" name="min_cost"
                                           value="{{ old('min_cost') }}">
                                </div>
                                <div class="form-group">
                                    <label>Cost</label>
                                    <input type="text" class="form-control" name="cost" value="{{ old('cost') }}">
                                </div>


                                <div class="form-group">
                                    <label for="inputState">Status</label>
                                    <select id="inputState" class="form-control" name="status">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection

@push('scripts')
    <script src="{{ asset('backend/assets/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('body').on('change', '.shipping-type', function () {
                let value = $(this).val();

                if (value !== 'min_cost') {
                    $('.min_cost').addClass('d-none')
                } else {
                    $('.min_cost').removeClass('d-none')
                }
            })
        })
    </script>
@endpush
