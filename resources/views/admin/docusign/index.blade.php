@extends('admin.base')

@section('section_title')
<strong>Docusign</strong>
@endsection

@section('section_body')




@if(!empty(App\Models\Option::get_option('docusign_auth_code')))
<a class="btn btn-danger text-white" href="{{route('admin.revoke.docusign')}}">Revoke Access</a>
@else
<button class="btn btn-primary connect-doc">Connect Docusign</button>
@endif
<hr />
<script>
    const docusignConnectEndpoint = "{{ route('admin.connect.docusign') }}";
    $(document).on('click', '.connect-doc', function() {
        $(this).text('connecting...');
        const popupWindow = window.open(docusignConnectEndpoint, 'docusignConnectWindow', 'toolbar=0,status=0,height=500,width=800');
        var timer = setInterval(function() {
            if (popupWindow.closed) {
                clearInterval(timer);
                window.location.reload();
            }
        }, 1000);
    });
</script>
@endsection