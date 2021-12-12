<!-- Single Widget -->
<div class="widget price mb-30">
    <h6 class="widget-title">Filter by Price</h6>
    <div class="widget-desc">
        @php
            $min = \App\Utilities\Helpers::minPrice();
            $max = \App\Utilities\Helpers::maxPrice()
        @endphp
        <div class="slider-range">
            <div id="slider-range" data-min="{{$min}}" data-max="{{$max}}" data-unit="$"
                 class="slider-range-price ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"
                 data-value-min="{{$min}}" data-value-max="{{$max}}" data-label-result="Price:">
                <div class="ui-slider-range ui-widget-header ui-corner-all"></div>
                <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
            </div>
            <input type="hidden" id="price_range"
                   value="@if(!empty($_GET['price'])) {{$_GET['price']}}@endif"
                   name="price_range">
            <input type="text" id="amount"
                   value="@if(!empty($_GET['price'])) @php $price = explode('-',$_GET['price']); echo '$'.$price[0].'-$'.$price[1] @endphp @else${{$min}}-${{$max}}@endif"
                   readonly>
            <button type="submit" class="btn btn-sm btn-primary price_range_btn">Filter</button>
        </div>
    </div>
</div>
