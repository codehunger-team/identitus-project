@component('mail::message')
# Counter <br> <br> <hr>

## First Payment :<h2 class="font-weight-bold">$ {{$data['first_payment']}}</h2><br>
## Period Payments :<h2 class="font-weight-bold">$ {{$data['period_payment']}}</h2><br>
## Periods :<h2 class="font-weight-bold">{{$data['number_of_periods']}}</h2><br>
## Option Purchase Price :<h2 class="font-weight-bold">$ {{$data['option_purchase_price']}}</h2><br>

<a href="{{ route('review.terms',$data['domain_name']) }}" class="button button-{{ $color ?? 'primary' }}" target="_blank" rel="noopener">Accept</a>&nbsp; &nbsp;
<a href="{{route('counter.offer',$data['domain_name'])}}" class="button button-{{ $color ?? 'primary' }}" target="_blank" rel="noopener">Counter Lease</a> <br>

Thanks,<br>
@endcomponent