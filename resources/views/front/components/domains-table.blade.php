<?php $i = 0; ?>
<table class="table" id="ajax-filtered-domains">
    <thead>
        <tr>
            <th scope="col">Domain <a class="sort" href="javascript:void(0)"><i class="fas fa-sort"></a></i></th>
            <th scope="col">Monthly Lease <a class="sort" href="javascript:void(0)"><i class="fas fa-sort"></a></th>
            <th scope="col">Purchase Price <a class="sort" href="javascript:void(0)"><i class="fas fa-sort"></a></th>
            <th scope="col">Options</th>
        </tr>
    </thead>
    <tbody>
        @foreach( $domains as $d )
        <?php $i++; ?>
        <tr>
            <td><a class="text-break" href="{{ $d->domain }}">{{ $d->domain }}</a></td>
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
<script>    
$(document).on('click','th',function(){
    var table = $(this).parents('table').eq(0)
    var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
    this.asc = !this.asc
    if (!this.asc){rows = rows.reverse()}
    for (var i = 0; i < rows.length; i++){table.append(rows[i])}
})
function comparer(index) {
    return function(a, b) {
        var valA = getCellValue(a, index), valB = getCellValue(b, index)
        return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB)
    }
}
function getCellValue(row, index){ return $(row).children('td').eq(index).text() }
</script>
