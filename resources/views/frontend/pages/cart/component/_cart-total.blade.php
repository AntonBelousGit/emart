<div class="cart-total-area mb-30">
    <h5 class="mb-3">Cart Totals</h5>
    <div class="table-responsive">
        <table class="table mb-3">
            <tbody>
            @php
                $save = '';
                if (isset($amount)) {
                    $save = number_format($amount['value'],2);
                }else{
                    $save = 0;
                }
            @endphp
            <tr>
                <td>Sub Total</td>
                <td>${{$full_cart::subtotal()}}</td>
            </tr>

            <tr>
                <td>Save amount</td>
                <td id="save-amount">
                    ${{$save}}
                </td>
            </tr>
            <tr>
                <td>Total</td>
                <td>$
                    @if (isset($amount))
                        {{number_format($full_cart::subtotal(2,'.','') - $amount['value'],2)}}
                    @else
                        {{$full_cart::subtotal()}}
                    @endif
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <a href="{{route('checkout1')}}" class="btn btn-primary d-block">Proceed To Checkout</a>
</div>
