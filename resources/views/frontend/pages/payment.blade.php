@extends('frontend.layouts.master')

@section('title')
    {{ $settings->site_name }} - Payment
@endsection

@section('content')
    <!--============================
        BREADCRUMB START
    ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>Payment</h4>
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="javascript:">Payment</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        BREADCRUMB END
    ==============================-->


    <!--============================
        PAYMENT PAGE START
    ==============================-->
    <section id="wsus__cart_view">
        <div class="container">
            <div class="wsus__pay_info_area">
                <div class="row">
                    <div class="col-xl-3 col-lg-3">
                        <div class="wsus__payment_menu" id="sticky_sidebar">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                 aria-orientation="vertical">

                                {{--<button class="nav-link common_btn active" id="v-pills-home-tab" data-bs-toggle="pill"--}}
                                {{--        data-bs-target="#v-pills-home" type="button" role="tab"--}}
                                {{--        aria-controls="v-pills-home"--}}
                                {{--        aria-selected="true">Card Payment--}}
                                {{--</button>--}}

                                <button class="nav-link common_btn active" id="v-pills-home-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-paypal" type="button" role="tab"
                                        aria-controls="v-pills-paypal"
                                        aria-selected="true"><i class="fab fa-paypal"></i> Paypal
                                </button>
                                <button class="nav-link common_btn" id="v-pills-profile-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-stripe" type="button" role="tab"
                                        aria-controls="v-pills-stripe" aria-selected="false"><i
                                        class="fab fa-stripe-s"></i> Stripe
                                </button>

                                <button class="nav-link common_btn" id="v-pills-razorpay-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-razorpay" type="button" role="tab"
                                        aria-controls="v-pills-razorpay" aria-selected="false"><i
                                        class="fas fa-file-invoice-dollar"></i> RazorPay
                                </button>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5">
                        <div class="tab-content" id="v-pills-tabContent" id="sticky_sidebar">
                            {{--<div class="tab-pane fade show active" id="v-pills-paypal" role="tabpanel"
                                 aria-labelledby="v-pills-home-tab">
                                <div class="row">
                                    <div class="col-xl-12 m-auto">
                                        <div class="wsus__payment_area">
                                            <form>
                                                <div class="wsus__pay_caed_header">
                                                    <h5>Credit or Debit Card</h5>
                                                    <img src="{{ asset('frontend/images/payment5.png') }}" alt="payment" class="img-=fluid">
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <input class="input" type="text"
                                                               placeholder="MD. MAHAMUDUL HASSAN SAZAL">
                                                    </div>
                                                    <div class="col-12">
                                                        <input class="input" type="text"
                                                               placeholder="2540 4587 **** 3215">
                                                    </div>
                                                    <div class="col-4">
                                                        <input class="input" type="text" placeholder="MM/YY">
                                                    </div>
                                                    <div class="col-4 ms-auto">
                                                        <input class="input" type="text" placeholder="1234">
                                                    </div>
                                                </div>
                                                <div class="wsus__save_payment">
                                                    <h6><i class="fas fa-user-lock"></i> 100% Secure Payment With :</h6>
                                                    <img src="{{ asset('frontend/images/payment1.png') }}" alt="payment" class="img-fluid">
                                                    <img src="{{ asset('frontend/images/payment2.png') }}" alt="payment" class="img-fluid">
                                                    <img src="{{ asset('frontend/images/payment3.png') }}" alt="payment" class="img-fluid">
                                                </div>
                                                <div class="wsus__save_card">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                               id="flexSwitchCheckDefault">
                                                        <label class="form-check-label"
                                                               for="flexSwitchCheckDefault">Save This Card</label>
                                                    </div>
                                                </div>
                                                <button type="submit" class="common_btn">Confirm</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>--}}

                            <div class="tab-pane fade show active" id="v-pills-paypal" role="tabpanel"
                                 aria-labelledby="v-pills-home-tab">
                                <div class="row">
                                    <div class="col-xl-12 m-auto">
                                        <div class="wsus__payment_area">
                                            <a class="nav-link common_btn text-center"
                                               href="{{ route('user.paypal.payment') }}"><i class="fab fa-paypal"></i>
                                                Pay with Paypal</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @include('frontend.pages.payment-gateway.stripe')

                            @include('frontend.pages.payment-gateway.razorpay')

                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4">
                        <div class="wsus__pay_booking_summary" id="sticky_sidebar2">
                            <h5>Order Summary</h5>
                            <p>Subtotal: <span>{{ $settings->currency_icon }}{{ getCartTotal() }}</span></p>
                            <p>Shipping fee (+): <span>{{ $settings->currency_icon }}{{ getShippingFee() }}</span></p>
                            <p>Coupon (-): <span>{{ $settings->currency_icon }}{{ getCartDiscount() }}</span></p>
                            <h6>Total <span>{{ $settings->currency_icon }}{{ getFinalPayableAmount() }}</span></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        PAYMENT PAGE END
    ==============================-->
@endsection
