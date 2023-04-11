<div class="card">
    <div class="card-header">
        <label for="card-element">
            Order Information
        </label>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Domain</th>
                        <th >Purchase Type</th>
                        <th class="align-middle">Price</th>

                    </tr>
                </thead>
                @if( \Cart::getContent()->count() )
                @php
                    $cart = \Cart::getContent(true);    
                @endphp
                <tbody>
                @foreach( $cart as $domain )
                    <tr>
                        <td class="text-primary align-middle">
                            <a href="{{route('ajax.remove.to.cart',$domain->id)}}" type="link"><svg
                                    class="bi bi-x-circle-fill" width="1em" height="1em" viewBox="0 0 16 16"
                                    fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.146-3.146a.5.5 0 0 0-.708-.708L8 7.293 4.854 4.146a.5.5 0 1 0-.708.708L7.293 8l-3.147 3.146a.5.5 0 0 0 .708.708L8 8.707l3.146 3.147a.5.5 0 0 0 .708-.708L8.707 8l3.147-3.146z" />
                                </svg> </a>
                            <a href="/info/{!! $domain->id !!}">{{ $domain->name }}</a>
                        </td>
                        <td>
                            {{ $domain->attributes[0] == 'lease' ? 'First Payment' : 'Purchase Payment' }}
                        </td>
                        <td class="text-right text-primary-price align-middle">
                            {{ \App\Models\Option::get_option( 'currency_symbol' ) . number_format($domain->price)}}
                        </td>
                        <td>

                        </td>
                    </tr>@endforeach
                    <tr>
                        <td colspan="1">
                            {{-- <h3>Total</h3> --}}
                        </td>
                        <td class="align-middle">
                            <h4>Bill Detail</h4>
                           
                        </td>
                        @php
                            $stripeFee = \Cart::getTotal() * 2.9 /100 + 0.30;
                            $grandTotal = $stripeFee + \Cart::getTotal();
                        @endphp
                        <td>
                                <strong>Sub Total:</strong>  {{ App\Models\Option::get_option( 'currency_symbol' ) . \Cart::getTotal() }} </br>
                                <strong>Card Transaction Fee:</strong>{{ App\Models\Option::get_option( 'currency_symbol' ) . $stripeFee }}  </br>
                                <strong>Grand Total:</strong> {{ App\Models\Option::get_option( 'currency_symbol' ) .$grandTotal }} </br>
                        </td>
                    </tr>
                </tbody>@else
                <tr>
                    <td colspan="1">
                        <h3>Your Cart is Empty</h3>
                    </td>
                    <td class="text-right">
                        <h3><strong>{{ App\Models\Option::get_option( 'currency_symbol' ) }}0.00</strong></h3>
                    </td>
                </tr>@endif
            </table>    
            <img src="{{asset('images/stripe-badge.png')}}" width="100%">
        </div>
    </div>
</div>