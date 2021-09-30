@php
    $items = \Cart::getContent();
@endphp
@if( \Cart::getContent()->count() )
    <div>
        <ul class="list-group cart_items_div" id="openModal" style="display: none;">
            @foreach($items as $item)
                <li class="list-group-item item_list" id="cart_div_{{$item->id}}">
                    <a class="text-bold" href="/info/{!! $item->id !!}">
                        {{ $item->name }}
                    </a>
                    <br>
                    <span>
                        <b>Price</b> : {{ \App\Models\Option::get_option( 'currency_symbol' ) . number_format($item->price)}}
                    </span>
                        <br>

                    <span>
                        <b>Type</b> : {{ $item->attributes[0] == 'lease' ? 'First Payment' : 'Purchase Payment' }}
                    <span>

                    <span class="delete_from_cart float-right">
                        <span value="{{$item->id}}"> <button type="button" class="btn btn-danger btn-sm text-white">Remove</button></span>
                    <span>

                </li>
            @endforeach
            <li class="list-group-item" style="border-top-width: 4px;">
                <b>Total :</b>
                <span style="float: right;" id="cart_total_price">
                    <b> {{ App\Models\Option::get_option( 'currency_symbol' ) . number_format(\Cart::getTotal(),0) }}</b>
                </span>
            </li>
            <li class="list-group-item" style="float: right;">
                <a href="{{route('checkout')}}" class="btn btn-primary">Checkout</a>
            </li>
        </ul>
    </div>
@endif
