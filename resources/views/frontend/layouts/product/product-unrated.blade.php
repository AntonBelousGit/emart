<div class="single-product-area mb-15">
    <div class="product_image">
    @php
        $photo = explode(',',$product->photo);
    @endphp
    <!-- Product Image -->
        <img class="normal_img" src="{{$photo[0]}}" alt="{{$product->title}}">
        @if (count($photo)>1)
            <img class="hover_img" src="{{$photo[1]}}" alt="{{$product->title}}">
    @endif
    <!-- Product Badge -->
        <div class="product_badge">
            <span>{{$product->condition}}</span>
        </div>

        <!-- Wishlist -->
        <div class="product_wishlist">
            <a href="wishlist.html"><i class="icofont-heart"></i></a>
        </div>

        <!-- Compare -->
        <div class="product_compare">
            <a href="compare.html"><i class="icofont-exchange"></i></a>
        </div>
    </div>

    <!-- Product Description -->
    <div class="product_description">
        <!-- Add to cart -->
        <div class="product_add_to_cart">
            <a href="#" data-quantity="1" data-product-id="{{$product->id}}" class="add_to_cart" id="add_to_cart{{$product->id}}"><i class="icofont-shopping-cart"></i> Add to Cart</a>
        </div>

        <!-- Quick View -->
        <div class="product_quick_view">
            <a href="#" data-toggle="modal" data-target="#quickview"><i class="icofont-eye-alt"></i> Quick View</a>
        </div>

        <p class="brand_name">{{$product->brand->title}}</p>
        <a href="{{route('product.detail',$product->slug)}}">{{ucfirst($product->title)}}</a>
        <h6 class="product-price">${{number_format($product->offer_price,2)}} <small><del class="text-danger">${{number_format($product->price,2)}}</del></small></h6>
    </div>
</div>
