@extends('admin.base')
@section('seo_title', 'Blogs')
@section('section_title', 'Blogs')
@section('section_body')
<!--Section Start-->
<div class="app-main__inner">
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto ms-auto text-end mt-n1">
            <a class="btn btn-primary" href="{{ route('blog.create') }}">+ Create Blog</a>
            <a class="btn btn-primary" href="{{ route('blog.category.index') }}">Blog Category</a>
            <a class="btn btn-primary" href="{{ route('subcategory.index') }}">Blog Sub-Category</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($blogs)
                                @foreach ($blogs as $key => $blog)
                                <tr>
                                    <td>{{ $blog->blogCategory->name }}</td>
                                    <td>{{ $blog->subcategory->name }}</td>
                                    <td>{{ $blog->name }}</td>
                                    <td>{{ substr(strip_tags($blog->description), 0, 50) }}</td>
                                    <td><span class="badge bg-{{ ($blog->status == 'active') ? 'success' : 'danger' }}">{{ ucwords($blog->status) }}</span></td>
                                    <td class="d-flex">
                                        <a target="_blank" class="btn btn-primary btn-shadow me-2" href="{{ route('frontknowledgebase.slug.maker', $blog->slug) }}">
                                            <i class="fa fa-eye" aria-hidden="true" title="{{ __('global-lang.view') }}"></i>
                                        </a>
                                        <a class="btn btn-primary btn-shadow me-2" href="{{ route('blog.edit', $blog->id) }}">
                                            <i class="fa fa-fw" aria-hidden="true" title="{{ __('global-lang.edit') }}"></i>
                                        </a>
                                        <a href="javascript:void(0)" id="{{ $blog->id }}" class="delete-knowledgebase btn btn-danger">
                                            <i class="fa fa-fw" aria-hidden="true" title="{{ __('global-lang.delete') }}"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                @endisset
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Section Start-->
@endsection
@include('blog::layouts.knowledgebaseScriptVariables')