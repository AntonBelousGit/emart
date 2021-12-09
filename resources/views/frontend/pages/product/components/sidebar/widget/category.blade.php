@if (count($categories)>0)
    <!-- Single Widget -->
    <div class="widget catagory mb-30">
        <h6 class="widget-title">Product Categories</h6>
        <div class="widget-desc">
            @if(!empty($_GET['category']))
                @php
                    $filter_cats = explode(',',$_GET['category'])
                @endphp
            @endif
            @foreach($categories as $category)
                <div class="custom-control custom-checkbox d-flex align-items-center mb-2">
                    <input type="checkbox" @if(!empty($filter_cats) && in_array($category->slug,$filter_cats)) checked @endif class="custom-control-input" id="{{$category->slug}}" name="category[]" onchange="this.form.submit();" value="{{$category->slug}}">
                    <label class="custom-control-label" for="{{$category->slug}}">{{ucfirst($category->title)}} <span
                            class="text-muted">({{$category->products->count()}})</span></label>
                </div>
            @endforeach
        </div>
    </div>
@endif

