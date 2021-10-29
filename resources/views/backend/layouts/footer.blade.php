<!-- Javascript -->
<script src="{{asset('backend/assets/bundles/libscripts.bundle.js')}}"></script>
<script src="{{asset('backend/assets/bundles/vendorscripts.bundle.js')}}"></script>

<script src="{{asset('backend/assets/bundles/jvectormap.bundle.js')}}"></script> <!-- JVectorMap Plugin Js -->
<script src="{{asset('backend/assets/bundles/morrisscripts.bundle.js')}}"></script><!-- Morris Plugin Js -->
<script src="{{asset('backend/assets/bundles/knob.bundle.js')}}"></script> <!-- Jquery Knob-->
<script src="{{asset('backend/assets/bundles/mainscripts.bundle.js')}}"></script> <!-- Jquery Knob-->

<script src="{{asset('backend/assets/bundles/mainscripts.bundle.js')}}"></script>
<script src="{{asset('backend/vendor/bootstrap-toggle/js/bootstrap4-toggle.min.js')}}"></script>
<script src="{{asset('backend/assets/js/index3.js')}}"></script>

@yield('script')

<script>
    $(".btn-toggle-offcanvas").on("click", function () {
        $("body").toggleClass("offcanvas-active")
    }), $("#main-content").on("click", function () {
        $("body").removeClass("offcanvas-active")
    })
    setTimeout(function () {
        $('#alert').slideUp();
    },5000);

</script>
