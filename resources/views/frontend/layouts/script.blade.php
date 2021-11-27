<!-- jQuery (Necessary for All JavaScript Plugins) -->
<script src="{{asset('frontend/js/jquery.min.js')}}"></script>
<script src="{{asset('frontend/js/popper.min.js')}}"></script>
<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
<script src="{{asset('frontend/js/jquery.easing.min.js')}}"></script>
<script src="{{asset('frontend/js/default/classy-nav.min.js')}}"></script>
<script src="{{asset('frontend/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('frontend/js/default/scrollup.js')}}"></script>
<script src="{{asset('frontend/js/waypoints.min.js')}}"></script>
<script src="{{asset('frontend/js/jquery.countdown.min.js')}}"></script>
<script src="{{asset('frontend/js/jquery.counterup.min.js')}}"></script>
<script src="{{asset('frontend/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('frontend/js/jarallax.min.js')}}"></script>
<script src="{{asset('frontend/js/jarallax-video.min.js')}}"></script>
<script src="{{asset('frontend/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('frontend/js/jquery.nice-select.min.js')}}"></script>
<script src="{{asset('frontend/js/wow.min.js')}}"></script>
<script src="{{asset('frontend/js/default/active.js')}}"></script>
<script src="{{asset('backend/vendor/sweetalert/sweetalert.min.js')}}"></script>

<script>
    setTimeout(function () {
        $('#alert').slideUp();
    },4000);
</script>
//delete product from cart
<script>
    $(document).on('click', '.cart_delete', function (e) {
        e.preventDefault();
        let cart_id = $(this).data('id');

        let token = '{{csrf_token()}}';
        let path = '{{route('cart.delete')}}';

        $.ajax({
            url: path,
            type: "POST",
            dataType: "JSON",
            data: {
                cart_id: cart_id,
                _token: token,
            },
            success: function (data) {

                if (data['status'] === true) {
                    $('body #header-ajax').html(data['header']);
                    $('body #cart_counter').html(data['cart_counter']);
                    $('body #cart-list').html(data['cart_list']);
                    swal({
                        title: "Good job!",
                        text: data['message'],
                        icon: "success",
                        button: "OK!",
                    });
                }
            },
            error: function (err) {
                console.log(err);
            }
        });
    });
</script>

//add to cart
<script>
    $(document).on('click', '.add_to_cart', function (e) {
        e.preventDefault();
        let product_id = $(this).data('product-id');
        let product_qty = $(this).data('quantity');

        let token = '{{csrf_token()}}';
        let path = '{{route('cart.store')}}';

        $.ajax({
            url: path,
            type: "POST",
            dataType: "JSON",
            data: {
                product_id: product_id,
                product_qty: product_qty,
                _token: token,
            },
            beforeSend: function () {
                $('#add_to_cart' + product_id).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
            },
            complete: function () {
                $('#add_to_cart' + product_id).html('<i class="fa fa-cart-plus "></i> Add to Cart');

            },
            success: function (data) {

                if (data['status'] === true) {
                    $('body #header-ajax').html(data['header']);
                    $('body #cart_counter').html(data['cart_counter']);
                    swal({
                        title: "Good job!",
                        text: data['message'],
                        icon: "success",
                        button: "OK!",
                    });
                }
            },
            error:function (err) {
                console.log(err);
            }
        });
    });
</script>


@yield('scripts')
