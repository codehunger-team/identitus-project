@extends('admin.base')

@section('section_title')
	<strong>Docusign</strong>
@endsection

@section('section_body')
    @if(!empty(App\Models\Option::get_option('docusign_auth_code')))
        <a class="btn btn-primary text-white" href="javascript:void(0)">Connected</a>
    @elseif (empty(App\Models\Option::get_option('docusign_client_id')))
	    <a class="btn btn-danger text-white" href="{{route('admin.configuration')}}">Please Set Client ID From Configuration</a>
    @else
        <a class="btn btn-primary" href="{{route('admin.connect.docusign')}}">Connect Docusign</a>
    @endif
<hr />
@endsection
