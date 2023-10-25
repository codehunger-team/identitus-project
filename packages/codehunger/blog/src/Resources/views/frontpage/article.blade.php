@extends('front.app')
@section('title', $article['name'])
@push('metadata')
<meta name="title" content="{{ $article['meta_title'] }}">
<meta name="description" content="{{ $article['meta_description'] }}">
<meta name="keywords" content="{{ $article['meta_keywords'] }}">
@endpush
@section('content')
<div class="content article mx-4" data-article="{{ $article['id'] }}">
    <div class="row">
        <div class="header-text">
            <h1>{{ $article['name'] }}</h1>
        </div>
        <div class="section1">
            <h3 class="text-primary">{{ $article['category']['name'] }}</h3>
        </div>
            <div class="col-xl-8">
                <div class="card mt-4">
                    <div class="card-body mt-3">
                        <div class="row">
                            <div class="col-md-9">
                                <h2>{{ $article['name'] }}</h2>
                            </div>
                            <div class="col-md-3">
                                <div class="float-end">
                                    @include('knowledgebase::frontpage.templates.likeDislike')
                                </div>
                            </div>
                        </div>
                        <div class="article-meta">
                            <span><i class="fa fa-clock text-muted mr-0"></i> {{ date('h:i A', strtotime($article['created_at'])) }}</span>
                            <span><i class="fa fa-calendar text-muted"></i> {{ date('d-m-Y', strtotime($article['created_at'])) }}</span>
                            <span><i class="fa fa-eye text-muted"></i> {{ $article['views_count'] }}</span>
                        </div>
                        <div class="mt-3">
                            {!! $article['description'] !!}
                        </div>
                    </div>
                </div>
            </div>
            @include('knowledgebase::frontpage.templates.sidebar')
    </div>
</div>
@endsection