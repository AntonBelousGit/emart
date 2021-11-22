<!doctype html>
<html lang="en">

<head>
  @include('frontend.layouts.head')
</head>

<body>
<!-- Preloader -->
@include('frontend.layouts.preloader')

<!-- Header Area -->
@include('frontend.layouts.header')
<!-- Header Area End -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @include('backend.layouts.notification')
        </div>
    </div>
</div>


@yield('content')

<!-- Footer Area -->
@include('frontend.layouts.footer')
<!-- Footer Area -->

@include('frontend.layouts.script')

</body>

</html>
