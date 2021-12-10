@extends('frontend.layouts.app')

@section('content')

    <!-- Quick View Modal Area -->
    <div class="modal fade" id="quickview" tabindex="-1" role="dialog" aria-labelledby="quickview" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body">
                    <div class="quickview_body">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 col-lg-5">
                                    <div class="quickview_pro_img">
                                        <img class="first_img" src="img/product-img/new-1-back.png" alt="">
                                        <img class="hover_img" src="img/product-img/new-1.png" alt="">
                                        <!-- Product Badge -->
                                        <div class="product_badge">
                                            <span class="badge-new">New</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-7">
                                    <div class="quickview_pro_des">
                                        <h4 class="title">Boutique Silk Dress</h4>
                                        <div class="top_seller_product_rating mb-15">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        </div>
                                        <h5 class="price">$120.99 <span>$130</span></h5>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia expedita
                                            quibusdam aspernatur, sapiente consectetur accusantium perspiciatis
                                            praesentium eligendi, in fugiat?</p>
                                        <a href="shop-grid-left-sidebar.html#">View Full Product Details</a>
                                    </div>
                                    <!-- Add to Cart Form -->
                                    <form class="cart" method="post">
                                        <div class="quantity">
                                            <input type="number" class="qty-text" id="qty" step="1" min="1" max="12"
                                                   name="quantity" value="1">
                                        </div>
                                        <button type="submit" name="addtocart" value="5" class="cart-submit">Add to
                                            cart
                                        </button>
                                        <!-- Wishlist -->
                                        <div class="modal_pro_wishlist">
                                            <a href="wishlist.html"><i class="icofont-heart"></i></a>
                                        </div>
                                        <!-- Compare -->
                                        <div class="modal_pro_compare">
                                            <a href="compare.html"><i class="icofont-exchange"></i></a>
                                        </div>
                                    </form>
                                    <!-- Share -->
                                    <div class="share_wf mt-30">
                                        <p>Share with friends</p>
                                        <div class="_icon">
                                            <a href="shop-grid-left-sidebar.html#"><i class="fa fa-facebook"
                                                                                      aria-hidden="true"></i></a>
                                            <a href="shop-grid-left-sidebar.html#"><i class="fa fa-twitter"
                                                                                      aria-hidden="true"></i></a>
                                            <a href="shop-grid-left-sidebar.html#"><i class="fa fa-pinterest"
                                                                                      aria-hidden="true"></i></a>
                                            <a href="shop-grid-left-sidebar.html#"><i class="fa fa-linkedin"
                                                                                      aria-hidden="true"></i></a>
                                            <a href="shop-grid-left-sidebar.html#"><i class="fa fa-instagram"
                                                                                      aria-hidden="true"></i></a>
                                            <a href="shop-grid-left-sidebar.html#"><i class="fa fa-envelope-o"
                                                                                      aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quick View Modal Area -->

    <!-- Breadcumb Area -->
    <div class="breadcumb_area">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <h5>Shop Grid</h5>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                        <li class="breadcrumb-item active">Shop Grid</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcumb Area -->

    <section class="shop_grid_area section_padding_100">
        <div class="container">
            <form action="{{route('shop.filter')}}" method="post">
                @csrf
                <div class="row">

                    <div class="col-12 col-sm-5 col-md-4 col-lg-3">
                        @include('frontend.pages.product.components.sidebar.sidebar')
                    </div>

                    <div class="col-12 col-sm-7 col-md-8 col-lg-9">
                        <!-- Shop Top Sidebar -->
                        <div class="shop_top_sidebar_area d-flex flex-wrap align-items-center justify-content-between">
                            <div class="view_area d-flex">
                                <div class="grid_view">
                                    <a href="shop-grid-left-sidebar.html" data-toggle="tooltip" data-placement="top"
                                       title="Grid View"><i class="icofont-layout"></i></a>
                                </div>
                                <div class="list_view ml-3">
                                    <a href="shop-list-left-sidebar.html" data-toggle="tooltip" data-placement="top"
                                       title="List View"><i class="icofont-listine-dots"></i></a>
                                </div>
                            </div>
                            <select id="sortBy" name="sortBy" onchange="this.form.submit();" class="small right">
                                <option value="" selected>Default sort</option>
                                <option value="priceAsc" @if (isset($_GET['sortBy']) && $_GET['sortBy'] === 'priceAsc') selected @endif>Price - Lower To Higher</option>
                                <option value="priceDesc" @if (isset($_GET['sortBy']) && $_GET['sortBy'] === 'priceDesc') selected @endif>Price - Higher To Lower</option>
                                <option value="titleAsc" @if (isset($_GET['sortBy']) && $_GET['sortBy'] === 'titleAsc') selected @endif>Alphabetical Ascending</option>
                                <option value="titleDesc" @if (isset($_GET['sortBy']) && $_GET['sortBy'] === 'titleDesc') selected @endif>Alphabetical Descending</option>
                                <option value="discAsc" @if (isset($_GET['sortBy']) && $_GET['sortBy'] === 'discAsc') selected @endif>Discount - Lower To Higher</option>
                                <option value="discDesc" @if (isset($_GET['sortBy']) && $_GET['sortBy'] === 'discDesc') selected @endif>Discount - Higher To Lower</option>
                            </select>
                        </div>

                        <div class="shop_grid_product_area">
{{--                            <p>Total products: {{$products->total()}}</p>--}}
                            <div class="row justify-content-center">
                                <!-- Single Product -->
                                @dd($products)
                                @if (count($products)>0)
                                    @foreach($products as $product)
                                        <div class="col-9 col-sm-12 col-md-6 col-lg-4">
                                            @include('frontend.layouts.product.product-unrated')
                                        </div>
                                    @endforeach
                                @else
                                    <p>No product found!</p>
                                @endif

                            </div>
                        </div>

                        {{$products->withQueryString()->links('vendor.pagination.custom')}}
                    </div>

                </div>
            </form>
        </div>
    </section>
@endsection
