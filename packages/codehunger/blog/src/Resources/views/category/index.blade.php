@extends('admin.base')
@section('seo_title', 'Blog Categories')
@section('section_title', 'Blog Categories')
@section('section_body')
<!--Section Start-->
<div class="app-main__inner">
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto ms-auto text-end mt-n1">
            <button type="button" data-bs-toggle="modal" data-bs-target="#knowledgebaseCategoryCreateModal" class="render-create btn btn-primary btn-shadow">
                + Create Blog Category</button>
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
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($categories)
                                @foreach ($categories as $key => $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ substr(strip_tags($category->description), 0, 50) }}</td>
                                    <td>
                                        <a class="render-edit btn btn-primary btn-shadow" id="{{ $category->id }}">
                                            <i class="fa fa-fw" aria-hidden="true" title="edit category"></i>
                                        </a>
                                        <a href="javascript:void(0)" id="{{ $category->id }}" class="delete-category btn btn-danger">
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
@include('blog::category.component.createCategory')
@include('blog::category.component.editCategory')
<!--Section End-->
@push('scripts')
<script>
    var categoryDeleteTitle = "Delete Blog Category?";
    var categoryDeleteText = "Once Deleted, All Related Data Will Be Deleted!";
    var categoryDeleteUrl = "{{route('blog.category.destroy', ':id')}}";
    var categoryDeleteSuccess = "Blog Category Deleted Successfully";
    var categoryDeleteError = "Error Deleting Blog Category";
    var categoryNotDeleted = "Blog Category Not Deleted";
    var categoryEditUrl = "{{route('blog.category.edit', ':id')}}";
    var categoryUpdateUrl = "{{route('blog.category.update', ':id')}}";
</script>
<script>
    $(document).on('click', '.delete-category', function() {
        swal({
                title: categoryDeleteTitle,
                text: categoryDeleteText,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    var id = $(this).attr('id');
                    var url = categoryDeleteUrl;
                    url = url.replace(':id', id);
                    $.ajax({
                        type: "post",
                        url: url,
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            swal(categoryDeleteSuccess, {
                                icon: "success",
                            }).then(function() {
                                location.reload();
                            })
                        },
                        error: function(data) {
                            swal(categoryDeleteError, {
                                icon: "warning",
                            });
                        },
                    });
                } else {
                    swal(categoryNotDeleted);
                }
            });
    });

    // edit category modal code
    $(document).on('click', '.render-edit', function() {
        var id = $(this).attr('id');
        var url = categoryEditUrl;
        url = url.replace(':id', id);
        axios({
                method: "post",
                url: url,
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
            })
            .then((res) => {
                var updateUrl = categoryUpdateUrl.replace(':id', res.data.id);
                $('#knowledgebaseCategoryUpdateModal').find('form').attr('action', updateUrl);
                $("#knowledgebaseCategoryUpdateModal").find('input[name="name"]').val(res.data.name);
                $("#knowledgebaseCategoryUpdateModal").find('textarea[name="description"]').val(res.data.description);
                $("#knowledgebaseCategoryUpdateModal").find("input[name=title_view][value=" + res.data.title_view + "]").prop('checked', true);
                $("#knowledgebaseCategoryUpdateModal").modal('show');
            });
    });
</script>
@endpush
@endsection