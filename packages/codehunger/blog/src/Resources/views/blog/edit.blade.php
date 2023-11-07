@extends('admin.base')
@section('seo_title', 'Edit Blog')
@section('section_title', 'Edit Blog')
@section('section_body')
<!--Section Start-->
<div class="app-main__inner">
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto ms-auto text-end mt-n1">
            <a class="btn btn-primary" href="{{ route('admin.blog.index') }}">Back</a>
        </div>
    </div>
    <form enctype="multipart/form-data" id="knowledgebase_form" action="{{ route('admin.blog.update', $blog->id) }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Category Title: <span class="text-danger">*</span></label>
                                    <select class="category-select form-select" name="blog_category_id" id="category_id">
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @if ($category->id ==
                                            $blog->category_id) selected @endif>
                                            {{ $category->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Sub-Category: <span class="text-danger">*</span></label>
                                    <select class="subcategory-select form-select" name="subcategory_id" id="subcategory_id">
                                        @foreach ($subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}" @if ($subcategory->id ==
                                            $blog->subcategory_id) selected @endif>
                                            {{ $subcategory->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('subcategory_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Blog Title:</label>
                                    <span class="text-danger">{{ __('*') }}</span>
                                    <input type="text" id="name" name="name" value="{{ $blog->name }}" class="name form-control" placeholder="{{ __('knowledgebase::lang.knowledgebase_title_placeholder') }}">
                                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                    <div class="invalid-feedback">
                                        {{ __('knowledgebase::lang.knowledgebase_title_validation_error') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Blog Slug:</label>
                                    <span class="text-danger">{{ __('*') }}</span>
                                    <input onclick="$(this).removeAttr('readonly')" readonly type="text" id="slug" name="slug" class="slug form-control" placeholder="{{ __('knowledgebase::lang.knowledgebase_slug_placeholder') }}" required value="{{ $blog->slug }}">
                                    @error('slug') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Status:</label>
                                    <span class="text-danger">{{ __('*') }}</span>
                                    <select class="category-select form-select" name="status" id="status" aria-label="Default select example">
                                        <option value="active" {{ $blog->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $blog->status == 'inactive' ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                    @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                            <label for="knowledgebase">Description:</label><span class="text-danger">{{ __('*') }}</span>
                            <textarea id="description_html" name="description" hidden></textarea>
                            <div id="editor_container">
                                {!! $blog->description !!}
                            </div>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
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
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Featured Image:</label>
                            <input type="file" name="featured_image" class="form-control" accept="image/*">
                            @error('featured_image') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <img width="300" src="{{ url($blog->featured_image) }}" class="featured-image">
                    </div>
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
                    <input name="meta_title" class="form-control" value="{{ $blog->meta_title }}" placeholder="{{ __('knowledgebase::lang.enter_meta_placeholder') }}">
                    @error('meta_title') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Meta Description:</label>
                    <textarea class="form-control" rows="3" name="meta_description" placeholder="Enter Meta Description">{{ $blog->meta_description }}</textarea>
                    @error('meta_description') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Meta Keywords:</label>
                    <input name="meta_keywords" class="form-control" value="{{ $blog->meta_keywords }}" placeholder="e.g: tag1, tag2">
                    @error('meta_keywords') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary mt-3">Update</button>
            </div>
        </div>
    </form>
</div>
<!--Section End-->
@endsection
@include('blog::layouts.knowledgebaseScriptVariables')