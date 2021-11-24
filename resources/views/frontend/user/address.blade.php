@extends('frontend.layouts.app')

@section('content')

    <!-- Breadcrumb Area -->
    <div class="breadcumb_area">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <h5>My Account</h5>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                        <li class="breadcrumb-item active">My Account</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area -->

    <!-- My Account Area -->
    <section class="my-account-area section_padding_100_50">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-3">
                    <div class="my-account-navigation mb-50">
                        @include('frontend.user.layouts.sidebar')
                    </div>
                </div>
                <div class="col-12 col-lg-9">
                    <div class="my-account-content mb-50">
                        <p>The following addresses will be used on the checkout page by default.</p>

                        <div class="row">
                            <div class="col-12 col-lg-6 mb-5 mb-lg-0">
                                <h6 class="mb-3">Billing Address</h6>
                                <address>
                                    {{$user->address}}<br>
                                    {{$user->state}}, {{$user->city}} <br>
                                    {{$user->country}} <br>
                                    {{$user->postcode}} <br>
                                </address>
                                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal"
                                   data-target="#editAddress">Edit Address</a>

                            </div>
                            <div class="col-12 col-lg-6">
                                <h6 class="mb-3">Shipping Address</h6>
                                <address>
                                    {{$user->saddress}}<br>
                                    {{$user->sstate}}, {{$user->scity}} <br>
                                    {{$user->scountry}} <br>
                                    {{$user->spostcode}} <br>
                                </address>
                                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal"
                                   data-target="#editSAddress">Edit Address</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- My Account Area -->
@endsection

@section('popup')
    <!-- Modal -->
    <div class="modal fade" id="editAddress" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Address</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('billing.address',$user->id)}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input name="address" id="address" class="form-control" value="{{$user->address}}">
                        </div>
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input name="country" id="country" placeholder="Ukraine" class="form-control"
                                   value="{{$user->country}}">
                        </div>
                        <div class="form-group">
                            <label for="postcode">Postcode</label>
                            <input name="postcode" id="postcode" placeholder="44456" class="form-control"
                                   value="{{$user->postcode}}">
                        </div>
                        <div class="form-group">
                            <label for="state">State</label>
                            <input name="state" id="state" placeholder="state 23" class="form-control"
                                   value="{{$user->state}}">
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input name="city" id="city" placeholder="Dnipro" class="form-control"
                                   value="{{$user->city}}">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editSAddress" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Shipping Address</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('sipping.address',$user->id)}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="saddress">Shipping Address</label>
                            <input name="saddress" id="saddress" class="form-control" value="{{$user->saddress}}">
                        </div>
                        <div class="form-group">
                            <label for="scountry">Shipping Country</label>
                            <input name="scountry" id="scountry" placeholder="Ukraine" class="form-control"
                                   value="{{$user->scountry}}">
                        </div>
                        <div class="form-group">
                            <label for="spostcode">Shipping Postcode</label>
                            <input name="spostcode" id="spostcode" placeholder="44456" class="form-control"
                                   value="{{$user->spostcode}}">
                        </div>
                        <div class="form-group">
                            <label for="sstate">Shipping State</label>
                            <input name="sstate" id="sstate" placeholder="state 23" class="form-control"
                                   value="{{$user->sstate}}">
                        </div>
                        <div class="form-group">
                            <label for="scity">Shipping City</label>
                            <input name="scity" id="scity" placeholder="Dnipro" class="form-control"
                                   value="{{$user->scity}}">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
