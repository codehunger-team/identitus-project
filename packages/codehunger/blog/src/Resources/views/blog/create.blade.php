@extends('admin.base')
@section('seo_title', 'Create Blog')
@section('section_title', 'Create Blog')
@section('section_body')
<!--Section Start-->
<div class="app-main__inner">
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto ms-auto text-end mt-n1">
            <a class="btn btn-primary" href="{{ route('admin.blog.index') }}">Back</a>
        </div>
    </div>
    <form id="knowledgebase_form" action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf
        <div class="main-card mb-3 card">
            <div class="card-header">
                <div class="card-title">Blog Details</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Category Title: </label><span class="text-danger">{{ __('*') }}</span>
                                    <select class="category-select form-select" name="blog_category_id" id="blog_category_id" aria-label="Default select example" required>
                                        <option disabled selected>
                                            Select Category
                                        </option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Sub-Category: </label><span class="text-danger">{{ __('*') }}</span>
                                    <select class="subcategory-select form-select" name="subcategory_id" id="subcategory_id" aria-label="Default select example" required>
                                        <option disabled selected>
                                            Select Sub-Category
                                        </option>
                                    </select>
                                    @error('subcategory_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Blog Title: </label>
                                    <span class="text-danger">{{ __('*') }}</span>
                                    <input type="text" id="name" name="name" class="name form-control" placeholder="Enter Blog Title" required>
                                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                    <div class="invalid-feedback">
                                        Please Enter Blog Title
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Blog Slug: </label>
                                    <span class="text-danger">{{ __('*') }}</span>
                                    <input readonly type="text" id="slug" name="slug" class="slug form-control" placeholder="Enter Blog Slug" required>
                                    @error('slug') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Status: </label><span class="text-danger">{{ __('*') }}</span>
                                    <select required class="category-select form-select" name="status" id="status" aria-label="Default select example">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                    @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="knowledgebase">Enter Blog</label><span class="text-danger">{{ __('*') }}</span>
                                    <textarea required id="description_html" name="description" hidden></textarea>
                                    <div id="editor_container">
                                    </div>
                                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header">
                <span class="card-title">Featured Image</span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Featured Image:</label>
                    <input type="file" name="featured_image" class="form-control" accept="image/*">
                    @error('featured_image') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header">
                <span class="card-title">SEO Settings</span>
            </div>
            <div class="card-body pt-0">
                <div class="form-group">
                    <label class="form-label">Meta Title:</label>
                    <input name="meta_title" class="form-control" placeholder="Enter Meta Title">
                </div>
                <div class="form-group">
                    <label class="form-label">Meta Description:</label>
                    <textarea class="form-control" rows="3" name="meta_description" placeholder="Enter Meta Description"></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Meta Keywords:</label>
                    <input name="meta_keywords" class="form-control" placeholder="e.g: tag1, tag2">
                </div>
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </div>
        </div>
    </form>
</div>
<!--Section End-->
@endsection
@include('blog::layouts.knowledgebaseScriptVariables')