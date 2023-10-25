@extends('layouts.app')
@section('title', __('knowledgebase::front.knowledgebase_title'))
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
<div class="home home-background">
    <div class="header-text mb-5">
        <h2 class="rufina-font-family text-primary">{{ getConfig("knowledgebase_articles_heading") }}</h2>
    </div>
    <div class="container mt-5 section2">
        <div class="col-lg-12 col-md-12 col-centr">
            <div class="row row-centr">
                @foreach($knowledgebases as $knowledgebase)
                <div class="col-md-4 view mb-3">
                    <div class="card p-3">
                        <div class="wave">
                            <h5>{{ $knowledgebase['name'] }}<span class="number">{{ count($knowledgebase['knowledgebase']) }}</span></h5>
                        </div>
                        <span class="rj_box mt-5">
                            @foreach($knowledgebase['knowledgebase'] as $knowledgebaseItem)
                            <span class="d-flex">
                                <i class="far fa-file-alt"></i>
                                <a class="text-decoration-none text-dark mt-2" href="{{ route('frontknowledgebase.slug.maker', $knowledgebaseItem['slug']) }}">
                                    <h6>{{ $knowledgebaseItem['name'] }}</h6>
                                </a>
                            </span>
                            @endforeach
                            <a href="{{ route('frontknowledgebase.subCategory.show', \Illuminate\Support\Str::slug($knowledgebase['name'], '-')) }}" class="btn btn-primary btn-xs round">{{ getConfig('articles_section_view_more_text') }}</a>
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="row mt-5 gx-2">
            <div class="col-md-6">
                <h3 class="h3">{{ getConfig("knowledgebase_popular_articles_heading") }}</h3>
                <div class="row knowledgebase-articles">
                    @foreach($popularKnowledgebases as $popularKnowledgebase)
                    <div class="mt-3">
                        <span>
                            <i class="fa fa-circle text-primary p-1 rounded-circle shadow"></i>
                            <span class="py-2 border-rounded k-article">
                                <a class="text-decoration-none text-dark" href="{{ route('frontknowledgebase.slug.maker', $popularKnowledgebase['slug']) }}">
                                    {{ $popularKnowledgebase['name'] }}
                                </a>
                            </span>
                        </span>
                        <hr class="knowledgebase-articles-bullets">
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6">
                <h3 class="h3">{{ getConfig("knowledgebase_latest_articles_heading") }}</h3>
                <div class="row knowledgebase-articles">
                    @foreach($recentKnowledgebases as $recentKnowledgebase)
                    <div class="mt-3">
                        <span>
                            <i class="fa fa-circle text-primary p-1 rounded-circle shadow"></i>
                            <span class="py-2 border-rounded k-article">
                                <a class="text-decoration-none text-dark" href="{{ route('frontknowledgebase.slug.maker', $recentKnowledgebase['slug']) }}">
                                    {{ $recentKnowledgebase['name'] }}
                                </a>
                            </span>
                        </span>
                        <hr class="knowledgebase-articles-bullets">
                    </div>
                    @endforeach
                </div>
            </div>
            <img class="knowledbase-search-img" src="{{ asset('images/knowledgebase-image-background.png') }}">
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