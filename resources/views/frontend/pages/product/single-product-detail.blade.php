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
                                        <a href="#">View Full Product Details</a>
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
                                            <a href="#"><i class="fa fa-facebook"
                                                           aria-hidden="true"></i></a>
                                            <a href="#"><i class="fa fa-twitter"
                                                           aria-hidden="true"></i></a>
                                            <a href="#"><i class="fa fa-pinterest"
                                                           aria-hidden="true"></i></a>
                                            <a href="#"><i class="fa fa-linkedin"
                                                           aria-hidden="true"></i></a>
                                            <a href="#"><i class="fa fa-instagram"
                                                           aria-hidden="true"></i></a>
                                            <a href="#"><i class="fa fa-envelope-o"
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
                    <h5>Product Details</h5>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Shop</a></li>
                        <li class="breadcrumb-item active">{{$product->title}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcumb Area -->

    <!-- Single Product Details Area -->
    <section class="single_product_details_area section_padding_100">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="single_product_thumb">
                        <div id="product_details_slider" class="carousel slide" data-ride="carousel">

                            <!-- Carousel Inner -->
                            <div class="carousel-inner">
                                @php
                                    $photos = explode(',',$product->photo);
                                @endphp
                                @foreach($photos as $key=>$photo)
                                    <div class="carousel-item {{$key==0 ? 'active': ''}}">
                                        <a class="gallery_img" href="{{$photo}}"
                                           title="{{$loop->iteration}} Slide">
                                            <img class="d-block w-100" src="{{$photo}}"
                                                 alt="{{$loop->iteration}} slide">
                                        </a>
                                        <!-- Product Badge -->
                                        <div class="product_badge">
                                            <span class="badge-new">New</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Carosel Indicators -->
                            <ol class="carousel-indicators">
                                @php
                                    $photos = explode(',',$product->photo);
                                @endphp
                                @foreach($photos as $key=>$photo)
                                    <li class="{{$key==0 ? 'active': ''}}" data-target="#product_details_slider"
                                        data-slide-to="{{$key}}"
                                        style="background-image: url({{$photo}});">
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Single Product Description -->
                <div class="col-12 col-lg-6">
                    <div class="single_product_desc">
                        <h4 class="title mb-2">{{ucfirst($product->title)}}</h4>
                        <div class="single_product_ratings mb-2">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <span class="text-muted">(8 Reviews)</span>
                        </div>
                        <h4 id="offer_price" class="price mb-4">${{number_format($product->offer_price,2)}}
                            <span id="original_price">${{number_format($product->price,2)}}</span></h4>

                        <!-- Overview -->
                        <div class="short_overview mb-4">
                            <h6>Overview</h6>
                            <p>{!! html_entity_decode($product->summary) !!}</p>
                        </div>

                        <!-- Color Option -->
                    {{--                        <div class="widget p-0 color mb-3">--}}
                    {{--                            <h6 class="widget-title">Color</h6>--}}
                    {{--                            <div class="widget-desc d-flex">--}}
                    {{--                                <div class="custom-control custom-radio">--}}
                    {{--                                    <input type="radio" id="customRadio1" name="customRadio"--}}
                    {{--                                           class="custom-control-input">--}}
                    {{--                                    <label class="custom-control-label black" for="customRadio1"></label>--}}
                    {{--                                </div>--}}
                    {{--                                <div class="custom-control custom-radio">--}}
                    {{--                                    <input type="radio" id="customRadio2" name="customRadio"--}}
                    {{--                                           class="custom-control-input">--}}
                    {{--                                    <label class="custom-control-label pink" for="customRadio2"></label>--}}
                    {{--                                </div>--}}
                    {{--                                <div class="custom-control custom-radio">--}}
                    {{--                                    <input type="radio" id="customRadio3" name="customRadio"--}}
                    {{--                                           class="custom-control-input">--}}
                    {{--                                    <label class="custom-control-label red" for="customRadio3"></label>--}}
                    {{--                                </div>--}}
                    {{--                                <div class="custom-control custom-radio">--}}
                    {{--                                    <input type="radio" id="customRadio4" name="customRadio"--}}
                    {{--                                           class="custom-control-input">--}}
                    {{--                                    <label class="custom-control-label purple" for="customRadio4"></label>--}}
                    {{--                                </div>--}}
                    {{--                                <div class="custom-control custom-radio">--}}
                    {{--                                    <input type="radio" id="customRadio5" name="customRadio"--}}
                    {{--                                           class="custom-control-input">--}}
                    {{--                                    <label class="custom-control-label white" for="customRadio5"></label>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}

                    <!-- Size Option -->
                        <div class="widget p-0 size mb-3">
                            <h6 class="widget-title">Size</h6>
                            <div class="widget-desc" style="height: 20px">
                                <select name="size" id="size">
                                    <option value=""></option>
                                    @foreach($product->attributes as $item)
                                        <option value="{{$item->size}}">{{$item->size}}</option>
                                    @endforeach
                                </select>

                                {{--                                <ul>--}}
                                {{--                                    <li><a href="#">XS</a></li>--}}
                                {{--                                    <li><a href="#">S</a></li>--}}
                                {{--                                    <li><a href="#">M</a></li>--}}
                                {{--                                    <li><a href="#">L</a></li>--}}
                                {{--                                    <li><a href="#">XL</a></li>--}}
                                {{--                                </ul>--}}
                            </div>
                        </div>

                        <!-- Add to Cart Form -->
                        <form class="cart clearfix my-5 d-flex flex-wrap align-items-center" method="post">
                            <div class="quantity">
                                <input type="number" class="qty-text form-control" id="qty2" step="1" min="1" max="12"
                                       name="quantity" value="1">
                            </div>
                            <button type="submit" id="add_to_cart_button_details_1" name="addtocart" value="5"
                                    class="btn btn-primary mt-1 mt-md-0 ml-1 ml-md-3">Add to cart
                            </button>
                        </form>

                        <!-- Others Info -->
                        <div class="others_info_area mb-3 d-flex flex-wrap">
                            <a class="add_to_wishlist" href="wishlist.html"><i class="fa fa-heart"
                                                                               aria-hidden="true"></i> WISHLIST</a>
                            <a class="add_to_compare" href="compare.html"><i class="fa fa-th" aria-hidden="true"></i>
                                COMPARE</a>
                            <a class="share_with_friend" href="#"><i class="fa fa-share"
                                                                     aria-hidden="true"></i> SHARE
                                WITH FRIEND</a>
                        </div>

                        <!-- Size Guide -->
                        <div class="sizeguide">
                            <h6>Size Guide</h6>
                            <div class="size_guide_thumb d-flex">
                                @php
                                    $size_guide = explode(',',$product->size_guide);
                                @endphp
                                @foreach($size_guide as $item)
                                    <a class="size_guide_img" href="{{$item}}"
                                       style="background-image: url({{$item}});">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product_details_tab section_padding_100_0 clearfix">
                        <!-- Tabs -->
                        <ul class="nav nav-tabs" role="tablist" id="product-details-tab">
                            <li class="nav-item">
                                <a href="#description" class="nav-link active" data-toggle="tab"
                                   role="tab">Description</a>
                            </li>
                            <li class="nav-item">
                                <a href="#reviews" class="nav-link" data-toggle="tab" role="tab">Reviews
                                    <span class="text-muted">({{$product->review->count()}})</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="#addi-info" class="nav-link" data-toggle="tab" role="tab">Additional
                                    Information</a>
                            </li>
                            <li class="nav-item">
                                <a href="#refund" class="nav-link" data-toggle="tab" role="tab">Return
                                    &amp; Cancellation</a>
                            </li>
                        </ul>
                        <!-- Tab Content -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade show active" id="description">
                                <div class="description_area">
                                    <h5>Description</h5>
                                    {!! $product->description !!}
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="reviews">

                                @if ($comments->count() > 0)
                                    <div class="reviews_area">
                                        <ul>
                                            <li>
                                                @foreach($comments as $item)
                                                    <div class="single_user_review mb-15">
                                                        <div class="review-rating">
                                                            @for ($i = 0; $i < 5; $i++)
                                                                @if ($item->rate > $i)
                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                @else
                                                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                                                @endif
                                                            @endfor
                                                            <span>for {{ucfirst($item->reason)}}</span>
                                                        </div>
                                                        <div class="review-details">
                                                            <p>by <b>{{$item->user->full_name}}</b> on
                                                                <span>{{\Carbon\Carbon::parse($item->created_at)->format('m D Y')}}</span>
                                                            </p>
                                                            <p>
                                                                {{$item->review}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </li>
                                        </ul>
                                    </div>
                                    {{$comments->links('vendor.pagination.custom')}}
                                @endif
                                <div class="submit_a_review_area mt-50">
                                    <h4>Submit A Review</h4>
                                    @auth
                                        <form action="{{route('product.review',$product->slug)}}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <span>Your Ratings</span>
                                                <div class="stars">
                                                    <input type="radio" name="rate" class="star-1" id="star-1"
                                                           value="1">
                                                    <label class="star-1" for="star-1">1</label>
                                                    <input type="radio" name="rate" class="star-2" id="star-2"
                                                           value="2">
                                                    <label class="star-2" for="star-2">2</label>
                                                    <input type="radio" name="rate" class="star-3" id="star-3"
                                                           value="3">
                                                    <label class="star-3" for="star-3">3</label>
                                                    <input type="radio" name="rate" class="star-4" id="star-4"
                                                           value="4">
                                                    <label class="star-4" for="star-4">4</label>
                                                    <input type="radio" name="rate" class="star-5" id="star-5"
                                                           value="5">
                                                    <label class="star-5" for="star-5">5</label>
                                                    <span></span>
                                                </div>
                                                @error('rate')
                                                <p class="text-danger">{{$message}}</p>
                                                @enderror
                                            </div>
                                            <input type="hidden" name="product_id" value="{{$product->id}}">
                                            <div class="form-group">
                                                <label for="options">Reason for your rating</label>
                                                <select class="form-control small right py-0 w-100" id="options"
                                                        name="reason">
                                                    <option value="quality" {{old('reason')== 'quality'?'selected':''}}>
                                                        Quality
                                                    </option>
                                                    <option value="value" {{old('reason')== 'value'?'selected':''}}>
                                                        Value
                                                    </option>
                                                    <option value="design" {{old('reason')== 'design'?'selected':''}}>
                                                        Design
                                                    </option>
                                                    <option value="price" {{old('reason')== 'price'?'selected':''}}>
                                                        Price
                                                    </option>
                                                    <option value="others" {{old('reason')== 'others'?'selected':''}}>
                                                        Others
                                                    </option>
                                                </select>
                                                @error('reason')
                                                <p class="text-danger">{{$message}}</p>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="comments">Comments</label>
                                                <textarea class="form-control" id="comments" rows="5"
                                                          data-max-length="150" name="review"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit Review</button>
                                        </form>
                                    @else
                                        <p class="py-2">You need to login for writing review.<a
                                                href="{{route('user.auth')}}">Click here </a>to login!</p>
                                    @endif
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="addi-info">
                                <div class="additional_info_area">
                                    <h5>Additional Info</h5>
                                    {!! $product->additional_info !!}
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="refund">
                                <div class="refund_area">
                                    <h6>Return Policy</h6>
                                    {!! $product->return_cancel !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Single Product Details Area End -->

    <!-- Related Products Area -->
    @if (count($product->rel_products)>0)
        @include('frontend.layouts.product.components.related-product')
    @endif

    <!-- Related Products Area -->

@endsection

@section('styles')
    <style>
        /*.nice-select.open .list{*/
        /*    width: 100%;*/
        /*}*/

        .widget.size .widget-desc li {
            display: block;
            margin-top: 4px;
        }
    </style>

@endsection

@section('scripts')
    <script>

        $('#size').change(function () {
            var size = $(this).val();
            $('.add_to_cart_button_details').attr('data-size', size);
            var product_id = {{$product->id}};

            if (product_id != null) {
                $.ajax({
                    url: '/get-product-price/' + product_id,
                    data: {
                        size: size,
                    },
                    type: 'GET',
                    success: function (response) {
                        if (response.status) {
                            var data = response.data;
                            $('#original_price').html('$' + data['original_price']);
                            $('#offer_price').html('$' + data['offer_price']);
                            $('#add_to_cart_button_details_1').attr('data-price', data['offer_price']);
                        }
                    }
                });
            }

        })

    </script>
@endsection
