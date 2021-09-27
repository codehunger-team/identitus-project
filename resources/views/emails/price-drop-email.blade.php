
@component('mail::message')
# Price Has Been Dropped <br> <br> <hr>
## Domain Name :<h2 class="font-weight-bold">{{$data['domain_name']}}</h2><br>
## First Payment :<h2 class="font-weight-bold">$ {{$data['first_payment']}}</h2><br>
## Period Payments :<h2 class="font-weight-bold">$ {{$data['period_payment']}}</h2><br>
## Periods :<h2 class="font-weight-bold">{{$data['number_of_periods']}}</h2><br>
## Option Purchase Price :<h2 class="font-weight-bold">$ {{$data['option_price']}}</h2><br>


<a href="{{ route('review.terms',$data['domain_name']) }}" class="button button-{{ $color ?? 'primary' }}" target="_blank" rel="noopener">Lease Now</a>&nbsp; &nbsp;

<h1> <strong class="text-success">price is successfully drop!!!</strong> </h1><br>

Thanks,<br>
@endcomponent