@extends('admin.base')

@section('section_title')
	<strong>Docusign</strong>
@endsection

@section('section_body')




    @if(!empty(App\Models\Option::get_option('docusign_auth_code')))
        <a class="btn btn-danger text-white" href="{{route('admin.revoke.docusign')}}">Revoke Access</a>
    @else
        <button class="btn btn-primary connect-doc"><a class="" href="{{route('admin.connect.docusign')}}">Connect Docusign</a></button>
    @endif
<hr />
<script>
    $(document).on('click','.connect-doc',function(){
        $('.connect-doc').attr('disabled',true)
        $(this).text('connecting...');
    });
</script>
@endsection
