<div class="col-xl-4 mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white m-0">
            <div class="text-center">
                <span class="fs-5">Do You Have Questions?</span>
            </div>
        </div>
        <div class="card-body">
            <div class="input-group-lg">
                <input id="knowledgebase_search" type="text" class="form-control" placeholder="Ask Here...">
                <div id="searchList"></div>
            </div>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header bg-primary text-white m-0">
            <div class="text-center">
                <span class="fs-5">Recent Blogs</span>
            </div>
        </div>
        <div class="card-body p-0 sidebar-articles-list">
            @foreach($recentBlogs as $recentBlog)
            <div class="col mt-2 mx-3 p-2">
                <a class="text-muted" href="{{ route('frontknowledgebase.slug.maker', $recentBlog['slug']) }}"><i class="fa fa-newspaper text-muted mr-0"></i> {{ $recentBlog['name'] }}</a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@include('blog::frontpage.templates.sidebar-scripts')