<section class="you_may_like_area section_padding_0_100 clearfix">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section_heading new_arrivals">
                    <h5>You May Also Like</h5>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="you_make_like_slider owl-carousel">
                    <!-- Single Product -->
                    @php
                        $main_product = $product->id;
                        print_r($main_product);
                    @endphp

                    @foreach($product->rel_products as $product)
                        @if ($main_product !== $product->id)
                            @include('frontend.layouts.product.product-unrated')
                        @endif
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>
