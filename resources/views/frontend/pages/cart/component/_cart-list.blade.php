<table class="table table-bordered mb-30">
    <thead>
    <tr>
        <th scope="col"><i class="icofont-ui-delete"></i></th>
        <th scope="col">Image</th>
        <th scope="col">Product</th>
        <th scope="col">Unit Price</th>
        <th scope="col">Quantity</th>
        <th scope="col">Total</th>
    </tr>
    </thead>
    <tbody>
    @php
        $cart = Cart::instance('shopping');
    @endphp

    @foreach($cart->content() as $item)
        <tr>
            <th scope="row">
                <i class="icofont-close cart_delete" data-id="{{$item->rowId}}"></i>
            </th>
            <td>
                <img src="{{$item->model->photo}}" alt="{{$item->name}}">
            </td>
            <td>
                <a href="{{route('product.detail',$item->model->slug)}}">{{$item->name}}</a>
            </td>
            <td>${{number_format($item->price,2)}}</td>
            <td>
                <div class="quantity">
                    <input type="number" data-id="{{$item->rowId}}" class="qty-text"
                           id="qty-input-{{$item->rowId}}" step="1" min="1" max="99"
                           name="quantity" value="{{$item->qty}}">
                    <input type="hidden" data-id="{{$item->rowId}}"
                           data-product-quantity="{{$item->model->stock}}"
                           id="update-cart-{{$item->rowId}}">
                </div>
            </td>
            <td>${{number_format($item->subtotal,2)}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
