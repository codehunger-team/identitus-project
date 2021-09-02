@extends('admin.base')

@section('section_title')
	<strong>Docusign</strong>
@endsection

@section('section_body')

<div id="ds-clickwrap"></div>
<script src="https://demo.docusign.net/clickapi/sdk/latest/docusign-click.js"></script>
<script>docuSignClick.Clickwrap.render({
      environment: 'https://demo.docusign.net',
      accountId: 'd80c3d92-abb5-4d3e-b77a-f73b31017826',
      clickwrapId: 'eda8cb9c-11bf-40d7-96d1-03ace60d849b',
      clientUserId: 'swe'
    }, '#ds-clickwrap');</script>


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
