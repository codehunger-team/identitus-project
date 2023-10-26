@extends('layouts.app')
@section('title', "Blogs")
@section('banner')
<div class="container height-310">
    <!-- Bootstrap Container-2 Start-->
    <div class="header-text">
        <h1>{{ getConfig('knowledgebase_page_heading') }}</h1>
    </div>
    <div class="row align-items-center justify-content-center top-mr-srh">
        <div class="text-center col-md-7 col-md-offset-7">
            <div class="custom-search1">
                <input id="searchKnowledgebase" type="text" class="form-control search-faq search-header-input knowledgebase-search" placeholder=' {{ getConfig("knowledgebase_search_placeholder") }}'>
            </div>
            <div id="searchList" style="display: none;"></div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="container mt-6">
    <div class="col-lg-12 col-md-12 col-centr">
        <div class="card">
            <div class="card-body">
                <div class="card-title h2">Latest Blogs</div>
                <div class="row mt-3">
                    @foreach($blogs as $blog)
                    <div class="col-md-6 mb-2">
                        <div class="card">
                            @if($blog->featured_image != null)
                            <a href="{{ route('frontknowledgebase.slug.maker', $blog->slug) }}">
                                <img src="{{ url($blog->featured_image) }}" class="card-img-top" alt="{{ $blog->name }}">
                            </a>
                            @endif
                            <div class="card-title p-2 h3">
                                <a href="{{ route('frontknowledgebase.slug.maker', $blog->slug) }}">
                                    {{ $blog->name }}
                                </a>
                            </div>
                            <div class="card-subtitle p-2 h6">
                                <i class="fa fa-folder text-muted mr-0"></i> <a class="text-primary" href="{{ route('frontknowledgebase.category.show', strtolower($blog['blogCategory']['name'])) }}">{{ $blog['blogCategory']['name'] }}</a> | <i class="fa fa-clock text-muted mr-0"></i> {{ date('M d y', strtotime($blog->created_at)) }}
                            </div>
                            <div class="card-body">
                                <p class="card-text">{!! substr($blog->description, 0, 25) !!}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    const knowledgebaseMainSearch = '{{ route("frontknowledgebase.subCategory.search") }}';
</script>
<script src="{{ url('js/module/knowledgebase/knowledgebasecommon.js') }}"></script>
@endpush