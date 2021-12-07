@extends('frontend.layouts.app')

@section('content')

    <!-- Breadcumb Area -->
    <div class="breadcumb_area">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <h5>Checkout</h5>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                        <li class="breadcrumb-item active">Checkout</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcumb Area -->

    <!-- Checkout Step Area -->
    <div class="checkout_steps_area">
        <a class="complated" href="checkout-2.html"><i class="icofont-check-circled"></i> Billing</a>
        <a class="complated" href="checkout-3.html"><i class="icofont-check-circled"></i> Shipping</a>
        <a class="complated" href="checkout-4.html"><i class="icofont-check-circled"></i> Payment</a>
        <a class="active" href="checkout-5.html"><i class="icofont-check-circled"></i> Review</a>
    </div>
    <!-- Checkout Step Area -->

    <!-- Checkout Area -->
    <div class="checkout_area section_padding_100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="checkout_details_area clearfix">
                        <h5 class="mb-30">Review Your Order</h5>

                        <div class="cart-table">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-30">
                                    <thead>
                                    <tr>
                                        <th scope="col">Image</th>
                                        <th scope="col">Product</th>
                                        <th scope="col">Unit Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cart_items as $item)
                                        <tr>

                                            <td>
                                                <img src="{{$item->model->photo}}" alt="{{$item->name}}">
                                            </td>
                                            <td>
                                                <a href="{{route('product.detail',$item->model->slug)}}">{{$item->name}}</a>
                                            </td>
                                            <td>${{number_format($item->price,2)}}</td>
                                            <td>
                                                <div class="quantity">
                                                    <div class="quantity">
                                                        {{$item->qty}}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>${{number_format($item->subtotal,2)}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-7 ml-auto">
                    <div class="cart-total-area">
                        <h5 class="mb-3">Cart Totals</h5>
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <tbody>
                                <tr>
                                    <td>Sub Total</td>
                                    <td>${{$full_cart::subtotal()}}</td>
                                </tr>
                                <tr>
                                    <td>Shipping</td>
                                    <td>${{number_format($checkout['delivery_charge'][0],2)}}</td>
                                </tr>
                                @if (\Illuminate\Support\Facades\Session::has('coupon'))
                                    <tr>
                                        <td>Coupon</td>
                                        <td>${{number_format($amount['value'],2)}}</td>
                                    </tr>
                                @endif

                                <tr>
                                    <td>Total</td>
                                    <td>$
                                        @if (isset($amount))
                                            {{number_format($full_cart::subtotal(2,'.','') + $checkout['delivery_charge'][0] - $amount['value'],2)}}
                                        @else
                                            {{number_format($full_cart::subtotal(2,'.','') + $checkout['delivery_charge'][0],2)}}
                                        @endif
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="checkout_pagination d-flex justify-content-end mt-3">
                            <a href="checkout-4.html" class="btn btn-primary mt-2 ml-2 d-none d-sm-inline-block">Go
                                Back</a>
                            <a href="{{route('checkout.store')}}" class="btn btn-primary mt-2 ml-2">Confirm</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout Area End -->


@endsection


@section('scripts')

@endsection
