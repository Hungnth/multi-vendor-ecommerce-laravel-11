@extends('admin.layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/select2/dist/css/select2.min.css') }}">
@endpush

@section('content')

    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Settings</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-2">
                                    <div class="list-group" id="list-tab" role="tablist">
                                        <a class="list-group-item list-group-item-action active" id="list-paypal-list"
                                           data-toggle="list" href="#list-paypal" role="tab">Paypal</a>
                                        <a class="list-group-item list-group-item-action" id="list-stripe-list"
                                           data-toggle="list" href="#list-stripe" role="tab">Stripe</a>
                                        <a class="list-group-item list-group-item-action" id="list-razorpay-list"
                                           data-toggle="list" href="#list-razorpay" role="tab">RazorPay</a>
                                        <a class="list-group-item list-group-item-action" id="list-settings-list"
                                           data-toggle="list" href="#list-settings" role="tab">Settings</a>
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="tab-content" id="nav-tabContent">

                                        @include('admin.payment-settings.sections.paypal-setting')
                                        @include('admin.payment-settings.sections.stripe-setting')
                                        @include('admin.payment-settings.sections.razorpay-setting')


                                        <div class="tab-pane fade" id="list-settings" role="tabpanel"
                                             aria-labelledby="list-settings-list">
                                            Lorem ipsum culpa in ad velit dolore anim labore incididunt do aliqua sit
                                            veniam commodo elit dolore do labore occaecat laborum sed quis proident
                                            fugiat sunt pariatur. Cupidatat ut fugiat anim ut dolore excepteur ut
                                            voluptate dolore excepteur mollit commodo.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="{{ asset('backend/assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
@endpush
