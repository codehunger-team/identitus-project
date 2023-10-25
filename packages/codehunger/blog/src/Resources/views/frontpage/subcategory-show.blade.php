@extends('front.app')
@section('title', $subCategory['name'])
@push('metadata')
<meta name="title" content="{{ $subCategory['name'] }}">
<meta name="description" content="{{ substr($subCategory['description'], 0, 160) }}">
@endpush
@section('content')
<div class="content article mx-4">
    <div class="row">
        <div class="header-text">
            <h1>{{ __('knowledgebase::lang.knowledgebase') }}</h1>
        </div>
        <div class="section1">
            <h3 class="text-primary">{{ $subCategory['name'] }}</h3>
        </div>
            <div class="col-xl-8">
                @foreach($articles as $article)
                <div class="card mb-2 mt-4">
                    <div class="card-body mt-3">
                        <h3 class="ms-2"><a class="text-decoration-none" href="{{ route('frontknowledgebase.slug.maker', $article['slug']) }}">{{ $article['name'] }}</a></h3>
                        <div class="article-meta">
                            <span><i class="fa fa-clock text-muted mr-0"></i> {{ date('h:i A', strtotime($article['created_at'])) }}</span>
                            <span><i class="fa fa-calendar text-muted"></i> {{ date('d-m-Y', strtotime($article['created_at'])) }}</span>
                            <span><i class="fa fa-eye text-muted"></i> {{ $article['views_count'] }}</span>
                        </div>
                        <div class="mt-3">
                            {!! substr($article['description'], 0, 200) !!}
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="text-center">
                    {!! $articles->links() !!}
                </div>
            </div>
            @include('knowledgebase::frontpage.templates.subcategory-sidebar')
    </div>
</div>
@endsection