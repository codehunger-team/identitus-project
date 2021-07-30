@component('mail::message')
# Customer Enquiry

Customer With Below Info Has Put Enquiry

@component('mail::table')
| Name       | Email         | Message  |
| ------------- |:-------------:| --------:|
| {{$data['name']}}     | {{$data['email']}}      | {{$data['message']}}      |

@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent