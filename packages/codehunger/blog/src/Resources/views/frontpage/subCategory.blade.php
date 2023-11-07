@extends('front.app')
@section('title', $article['name'])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="p-3">
                    <h1 class="h2 text-muted">{{ $article['name'] }}</h1>
                    <ul class="flex d-inline-flex sub-category-ul">
                        <li><i class="fa fa-clock"></i>
                            {{ \Carbon\Carbon::parse($article['created_at'])->format('M d Y'); }}</li>
                        <li><i class="fa fa-eye"></i> 101</li>
                    </ul>
                </div>
                <div class="card-body">
                    {{ $article['description'] }}
                </div>
            </div>
        </div>
        @include('knowledgebase::frontpage.templates.sidebar')
    </div>
</div>
@endsection
