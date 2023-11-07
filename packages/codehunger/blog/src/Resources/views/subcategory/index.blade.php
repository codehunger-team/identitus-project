@extends('admin.base')
@section('seo_title', 'Blog Sub-Category')
@section('section_title', 'Blog Sub-Category')
@section('section_body')
<!--Section Start-->
<div class="app-main__inner">
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto ms-auto text-end mt-n1">
            <button data-bs-toggle="modal" data-bs-target="#knowledgebaseSubCategoryCreateModal" type="button" class="modal-create btn btn-primary btn-shadow">
                + Create Sub-Category</button>
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
                                    <th>Sub-Category</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($subCategories)
                                @foreach ($subCategories as $key => $subCategory)
                                <tr>
                                    <td>{{ $subCategory->blogCategory->name }}</td>
                                    <td>{{ $subCategory->name }}</td>
                                    <td>{{ substr(strip_tags($subCategory->description), 0, 50) }}</td>
                                    <td>
                                        <a class="render-edit btn btn-primary btn-shadow" id="{{ $subCategory->id }}">
                                            <i class="fa fa-fw" aria-hidden="true" title="edit subcategory"></i>
                                        </a>
                                        <a href="javascript:void(0)" id="{{ $subCategory->id }}" class="delete-subcategory btn btn-danger">
                                            <i class="fa fa-fw" aria-hidden="true" title="delete"></i>
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
@include('blog::subcategory.component.create')
@include('blog::subcategory.component.edit')
<!--Section End-->
@endsection
@push('scripts')
<script>
    var subcategoryDeleteTitle = "Select Blog Sub-Category";
    subcategoryDeleteText = "Once Deleted, All Related Data Will Be Deleted";
    var subcategoryDeleteUrl = "{{route('admin.subcategory.destroy', ':id')}}";
    var subcategoryDeleteSuccess = "Blog Sub-Category Deleted";
    var subcategoryDeleteError = "Error Deleting Blog Sub-Category";
    var subcategoryNotDeleted = "Blog Sub-Category Not Deleted";
    var subcategoryEditUrl = "{{route('admin.subcategory.edit', ':id')}}";
    var subcategoryUpdateUrl = "{{route('admin.subcategory.update', ':id')}}";
</script>
<script>
    $(document).on('click', '.delete-subcategory', function() {
        swal({
                title: subcategoryDeleteTitle,
                text: subcategoryDeleteText,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    var id = $(this).attr('id');
                    var url = subcategoryDeleteUrl;
                    url = url.replace(':id', id);
                    $.ajax({
                        type: "post",
                        url: url,
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            swal(subcategoryDeleteSuccess, {
                                icon: "success",
                            }).then(function() {
                                location.reload();
                            })
                        },
                        error: function(data) {
                            swal(subcategoryDeleteError, {
                                icon: "warning",
                            });
                        },
                    });
                } else {
                    swal(subcategoryNotDeleted);
                }
            });
    });
    $(document).on('click', '.render-edit', function() {
        var id = $(this).attr('id');
        var url = subcategoryEditUrl;
        url = url.replace(':id', id);
        axios({
                method: "get",
                url: url,
            })
            .then((res) => {
                var updateUrl = subcategoryUpdateUrl.replace(':id', res.data.id);
                $('#knowledgebaseSubCategoryEditModal').find('form').attr('action', updateUrl);
                $("#knowledgebaseSubCategoryEditModal").find('input[name="name"]').val(res.data.name);
                $("#knowledgebaseSubCategoryEditModal").find('textarea[name="description"]').val(res.data.description);
                $("#knowledgebaseSubCategoryEditModal").find("select[name=blog_category_id]").val(res.data.blog_category_id);
                $("#knowledgebaseSubCategoryEditModal").modal('show')
            })
    });
</script>
@endpush