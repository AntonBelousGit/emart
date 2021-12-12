@if (count($brands)>0)

    <!-- Single Widget -->
    <div class="widget brands mb-30">
        <h6 class="widget-title">Filter by brands</h6>
        <div class="widget-desc">
            @if(!empty($_GET['brand']))
                @php
                    $filter_brands = explode(',',$_GET['brand'])
                @endphp
            @endif
            @foreach($brands as $brand)
                <div class="custom-control custom-checkbox d-flex align-items-center mb-2">
                    <input type="checkbox" @if(!empty($filter_brands) && in_array($brand->slug,$filter_brands)) checked @endif class="custom-control-input" id="{{$brand->slug}}" name="brand[]" onchange="this.form.submit();" value="{{$brand->slug}}">
                    <label class="custom-control-label" for="{{$brand->slug}}">{{ucfirst($brand->title)}} <span
                            class="text-muted">({{$brand->products->count()}})</span></label>
                </div>
            @endforeach
        </div>
    </div>

@endif
