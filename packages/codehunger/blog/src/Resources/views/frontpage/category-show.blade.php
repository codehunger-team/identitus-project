@extends('layouts.app')
@section('seo_title', $category['name'])
@section('content')
<div class="content article mt-6 px-5">
    <div class="row">
        <div class="section1">
            <h3 class="text-primary">{{ $category['name'] }}</h3>
        </div>
        <div class="col-xl-8">
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
            <div class="text-center">
                {!! $blogs->links() !!}
            </div>
        </div>
        @include('blog::frontpage.templates.sidebar')
    </div>
</div>
@endsection