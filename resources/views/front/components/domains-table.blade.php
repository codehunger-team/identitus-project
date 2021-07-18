<?php $i = 0; ?>
<table class="table" id="ajax-filtered-domains">
    <thead>
        <tr>
            <th scope="col">Domain</th>
            <th scope="col">Monthly Lease</th>
            <th scope="col">or Buy Now</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach( $domains as $d )
        <?php $i++; ?>
        <tr>
            <td><a href="{{ $d->domain }}">{{ $d->domain }} </a></td>
            @if (isset($d->contract->period_payment))
            <td>{{ App\Models\Option::get_option( 'currency_symbol' ) . number_format($d->contract->period_payment, 0) }}</td>
            @else
            <td><strong>Unavailable</strong></td>
            @endif
            <td>
                @if( !is_null($d->discount) AND ($d->discount != 0 ))
                <span
                    class="text-discount">{{ \App\Models\Option::get_option( 'currency_symbol' ) . number_format($d->pricing,0) }}</span>
                {{ App\Models\Option::get_option( 'currency_symbol' ) . number_format($d->discount, 0) }}
                @else
                {{ App\Models\Option::get_option( 'currency_symbol' ) . number_format($d->pricing, 0) }}
                @endif
            </td>
            <td>
                <div class="dropdown">
                    <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="buy"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Get
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="buy">
                        @if (isset($d->contract->period_payment))
                            <li><a href="{{route('review.terms',$d->domain)}}" class="dropdown-item">Lease Now</a></li>
                        @endif 
                            <li><a href="{{route('ajax.add-to-cart.buy',$d->domain)}}" class="dropdown-item">Buy Now</a></li>
                    </ul>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<?php $i++; ?>

