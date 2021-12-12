@if (count($sizes)>0)

    <!-- Single Widget -->
    <div class="widget brands mb-30">
        <h6 class="widget-title">Filter by Size</h6>
        <div class="widget-desc">
            @if(!empty($_GET['size']))
                @php
                    $filter_sizes = explode(',',$_GET['size'])
                @endphp
            @endif
            @foreach($sizes as $size)
                <div class="custom-control custom-checkbox d-flex align-items-center mb-2">
                    <input type="checkbox" @if(!empty($filter_sizes) && in_array($size->slug,$filter_sizes)) checked @endif class="custom-control-input" id="{{$size->slug}}" name="size[]" onchange="this.form.submit();" value="{{$size->slug}}">
                    <label class="custom-control-label" for="{{$size->slug}}">{{ucfirst($size->title)}} <span
                            class="text-muted">({{$size->products->count()}})</span></label>
                </div>
            @endforeach
        </div>
    </div>

@endif

