@extends('layouts.app')
@section('seo_title', $blog['name'])
@section('content')
<div class="content article mt-2 px-2" data-article="{{ $blog['id'] }}">
    <div class="row">
        <div class="col-xl-8">
            <div class="card mt-4">
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-md-12">
                            <img width="100%" src="{{ url($blog['featured_image']) }}" alt="{{ $blog['name'] }}" class="image-responsive">
                        </div>
                        <div class="col-md-9">
                            <h2>{{ $blog['name'] }}</h2>
                        </div>
                    </div>
                    <div class="article-meta">
                        <span><i class="fa fa-folder text-muted mr-0"></i> <a href="{{ route('frontknowledgebase.category.show', strtolower($blog['blogCategory']['name'])) }}">{{ $blog['blogCategory']['name'] }}</a></span>
                        <span><i class="fa fa-clock text-muted mr-0"></i> {{ date('h:i A', strtotime($blog['created_at'])) }}</span>
                        <span><i class="fa fa-calendar text-muted"></i> {{ date('d-m-Y', strtotime($blog['created_at'])) }}</span>
                        <span><i class="fa fa-eye text-muted"></i> {{ $blog['views_count'] }}</span>
                    </div>
                    <div class="mt-3">
                        {!! $blog['description'] !!}
                    </div>
                </div>
            </div>
        </div>
        @include('blog::frontpage.templates.sidebar')
    </div>
</div>
@endsection