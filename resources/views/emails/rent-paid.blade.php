<p>Hi {{$order->customer}},</p>



<p>Your rent payment for {{$d->domain}} in the amount of ${{$order->total}} is was paid at @if(isset($contracts->payment_due_date)){{ date('jS F Y', strtotime($contracts->payment_due_date) )}} @else {{ date('jS F Y')}} @endif using your card on file. </p>

<p>Identitius</p>



    