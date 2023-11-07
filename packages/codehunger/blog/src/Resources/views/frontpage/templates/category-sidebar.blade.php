<div class="col-xl-4">
    <div class="card">
        <div class="card-body">
            <div class="text-center mb-3">
                <span class="fs-5">Do You Have Questions?</span>
            </div>
            <div class="input-group-lg">
                <input id="knowledgebase_search" type="text" class="form-control" placeholder="Ask Here...">
                <div id="searchList"></div>
            </div>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header bg-primary text-white m-0">
            <div class="text-center">
                <span class="fs-5">{{ __('knowledgebase::front.subcategory') }}</span>
            </div>
        </div>
        <div class="card-body p-0 sidebar-articles-list">
            @foreach($subcategories as $subcategory)
            <div class="col mt-2">
                <a href="{{ route('frontknowledgebase.subCategory.show', \Illuminate\Support\Str::slug($subcategory['name'], '-')) }}" class="text-muted mt-2"><i class="fa fa-file-text"></i> {{ $subcategory['name'] }}</a>
            </div>
            @endforeach
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header bg-primary text-white m-0">
            <div class="text-center">
                <span class="fs-5">{{ __('knowledgebase::front.recent_knowledgebase') }}</span>
            </div>
        </div>
        <div class="card-body p-0 sidebar-articles-list">
            @foreach($recentKnowledgebases as $recentKnowledgebase)
            <div class="col mt-2 mx-2">
                <a class="text-muted" href="{{ route('frontknowledgebase.slug.maker', $recentKnowledgebase['slug']) }}"><i class="fa fa-file-text"></i> <span class="mt-2">{{ $recentKnowledgebase['name'] }}</span></a>
            </div>
            @endforeach
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header bg-primary text-white m-0">
            <div class="text-center">
                <span class="fs-5">{{ __('knowledgebase::front.popular_knowledgebase') }}</span>
            </div>
        </div>
        <div class="card-body p-0 sidebar-articles-list">
            @foreach($popularKnowledgebases as $popularKnowledgebase)
            <div class="col mt-2 mx-2">
                <a href="{{ route('frontknowledgebase.slug.maker', $popularKnowledgebase['slug']) }}"><span class="text-muted mt-2"><i class="fa fa-file-text"></i> {{ $popularKnowledgebase['name'] }}</span></a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@include('knowledgebase::frontpage.templates.sidebar-scripts')