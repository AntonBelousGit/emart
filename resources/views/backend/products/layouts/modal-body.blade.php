<strong>Summary:</strong>
<p>{!! html_entity_decode($product->summary) !!}</p>
<strong>Description:</strong>
<p>{!! html_entity_decode($product->description) !!}</p>

<div class="row">
    <div class="col-md-3">
        <strong>Price:</strong>
        <p>${{number_format($product->price,2)}}</p>
    </div>
    <div class="col-md-3">
        <strong>Offer Price:</strong>
        <p>${{number_format($product->offer_price,2)}}</p>
    </div>
    <div class="col-md-3">
        <strong>Stock:</strong>
        <p>{{$product->stock ?? ''}}</p>
    </div>
    <div class="col-md-3">
        <strong>Discount:</strong>
        <p>{{$product->discount ?? ''}}</p>
    </div>
</div>


<div class="row">
    <div class="col-md-6"><strong>Category:</strong>
        <p>{{$product->category->title ?? ''}}</p></div>
    <div class="col-md-6"><strong>Child Category:</strong>
        <p>{{$product->childCategory->title ?? ''}}</p></div>
</div>
<div class="row">
    <div class="col-md-6"><strong>Brand:</strong>
        <p>{{$product->brand->title ?? ''}}</p></div>
    <div class="col-md-6"><strong>Vendor:</strong>
        <p>{{$product->vendor->full_name ?? ''}}</p></div>
</div>

<div class="row">
    <div class="col-md-5">
        <strong>Conditions:</strong>
        <p class="badge badge-primary">{{$product->condition ?? ''}}</p>
    </div>
    <div class="col-md-3">
        <strong>Size:</strong>
        <p class="badge badge-success">{{$product->size->slug ?? ''}}</p>
    </div>
    <div class="col-md-4">
        <strong>Status:</strong>
        <p class="badge badge-warning">{{$product->status ?? ''}}</p>
    </div>
</div>
