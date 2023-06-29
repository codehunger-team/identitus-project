@component('mail::message')
# Customer Enquiry

Customer Details

@component('mail::table')
| Name       | Email         | Message  |
| ------------- |:-------------:| --------:|
| {{$data['name']}}     | {{$data['customer_email']}}      | {{$data['message']}}      |

@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
