@extends('frontend.layouts.app')

@section('content')
    <!-- Breadcrumb Area -->
    <div class="breadcumb_area">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <h5>Wishlist</h5>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                        <li class="breadcrumb-item active">Wishlist</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area -->

    <!-- Wishlist Table Area -->
    <div class="wishlist-table section_padding_100 clearfix">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="cart-table wishlist-table">
                        <div class="table-responsive" id="wishlist-list">
                            @include('frontend.pages.wishlist.component._wishlist-list')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Wishlist Table Area -->

@endsection

@section('scripts')
    <script>
        $(document).on('click', '.move-to-cart', function (e) {
            e.preventDefault();
            let rowId = $(this).data('id');
            let token = '{{csrf_token()}}';
            let path = '{{route('wishlist.move.cart')}}';

            $.ajax({
                url: path,
                type: "POST",
                data: {
                    _token: token,
                    rowId: rowId,
                },
                beforeSend: function () {
                    $(this).html('<i class="fa fa-spinner fa-spin"></i> Moving to Cart');
                },
                success: function (data) {
                    if (data['status'] === true) {
                        $('body #header-ajax').html(data['header']);
                        $('body #wishlist-list').html(data['wishlist']);
                        $('body #cart_counter').html(data['cart_counter']);
                        swal({
                            title: "Success!",
                            text: data['message'],
                            icon: "success",
                            button: "OK!",
                        });
                    } else {
                        swal({
                            title: "Opps!",
                            text: 'Something went wrong',
                            icon: "warning",
                            button: "OK!",
                        });
                    }

                },
                error: function (err) {
                    console.log(err)
                    swal({
                        title: "Error!",
                        text: 'Some error',
                        icon: "error",
                        button: "OK!",
                    });
                }
            });
        });
        $(document).on('click', '.wishlist_delete', function (e) {
            e.preventDefault();
            let rowId = $(this).data('id');
            let token = '{{csrf_token()}}';
            let path = '{{route('wishlist.delete')}}';

            $.ajax({
                url: path,
                type: "POST",
                data: {
                    _token: token,
                    rowId: rowId,
                },
                success: function (data) {
                    if (data['status'] === true) {
                        $('body #header-ajax').html(data['header']);
                        $('body #wishlist-list').html(data['wishlist']);
                        $('body #cart_counter').html(data['cart_counter']);
                        swal({
                            title: "Success!",
                            text: data['message'],
                            icon: "success",
                            button: "OK!",
                        });
                    } else {
                        swal({
                            title: "Opps!",
                            text: 'Something went wrong',
                            icon: "warning",
                            button: "OK!",
                        });
                    }

                },
                error: function (err) {
                    console.log(err)
                    swal({
                        title: "Error!",
                        text: 'Some error',
                        icon: "error",
                        button: "OK!",
                    });
                }
            });
        });
    </script>
@endsection
