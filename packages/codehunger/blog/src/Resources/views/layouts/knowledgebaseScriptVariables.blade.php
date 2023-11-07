@push('scripts')
<script>
    var knowledgebaseGetSubcategoryUrl = "{{ route('admin.blog.getsubcategory') }}";
    var quillplaceholder = 'Enter';
    var selectCategorySubCategoryWarning = "Please Select Blog Category and Sub Category!"
    var slugUrl = "{{ route('admin.blog.slug.create') }}";
    var slugCheckUrl = "{{ route('admin.blog.slug.check') }}";
    var knowledgebaseTitle = "{{__('global-lang.are-you-sure')}}";
    var knowledgebaseText = "{{__('knowledgebase::lang.knowledgebase_delete_warning')}}";
    var knowledgebaseUrl = "{{route('admin.blog.destroy', ':id')}}";
    var knowledgebaseSuccess = "{{__('knowledgebase::lang.knowledgebase_deleted')}}";
    var knowledgebaseError = "{{__('global-lang.something-went-wrong')}}";
    var knowledgebaseNotDeleted = "{{__('knowledgebase::lang.knowledgebase_not_deleted')}}";
</script>
<script>
    $(document).on('click', '.delete-knowledgebase', function() {
        swal({
                title: knowledgebaseTitle,
                text: knowledgebaseText,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    var id = $(this).attr('id');
                    var url = knowledgebaseUrl;
                    url = url.replace(':id', id);
                    $.ajax({
                        type: "post",
                        url: url,
                        data: {
                            '_token': $('meta[name=token]').attr('content'),
                        },
                        success: function(data) {
                            swal(knowledgebaseSuccess, {
                                icon: "success",
                            }).then(function() {
                                location.reload();
                            })
                        },
                        error: function(data) {
                            swal(knowledgebaseError, {
                                icon: "warning",
                            });
                        },
                    });
                } else {
                    swal(knowledgebaseNotDeleted);
                }
            });
    });

    function getSubcategories(category_id) {
        $.ajax({
            url: knowledgebaseGetSubcategoryUrl,
            type: "POST",
            data: {
                category_id: category_id,
                _token: $('meta[name=token]').attr('content'),
            },
            dataType: 'json',
            success: function(result) {
                $('#subcategory_id').html('<option disabled selected>Select Subcategory</option>');
                $.each(result.subcategories, function(key, value) {
                    $("#subcategory_id").append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
        });
    }
    $(document).on('change', '#blog_category_id', function() {
        var category_id = this.value;
        $("#subcategory_id").html('');
        getSubcategories(category_id);
    });

    var quill = new Quill('#editor_container', {
        modules: {
            toolbar: [
                [{
                    header: [1, 2, false]
                }],
                ['bold', 'italic', 'underline'],
                ['image', 'code-block']
            ]
        },
        placeholder: quillplaceholder,
        theme: 'snow'
    });
    var timer;
    $(document).on('keyup', '#name', function() {
        if (!$('#blog_category_id').val() || !$('#subcategory_id').val()) {
            swal(selectCategorySubCategoryWarning, {
                icon: "warning",
            })
            return;
        }
        clearInterval(timer);
        timer = setTimeout(function() {
            getTheSlug()
        }, 1000);
    });

    function getTheSlug() {
        $.ajax({
            method: 'POST',
            url: slugUrl,
            data: {
                _token: $('meta[name=token]').attr('content'),
                blog_category_id: $('#blog_category_id').val(),
                subcategory_id: $('#subcategory_id').val(),
                name: $('#name').val(),
            },
            success: function(data) {
                $('#slug').val(data.slug);
                $('#slug').attr('readonly', false);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
    $(document).on('change', '#slug', function(e) {
        $.ajax({
            method: 'POST',
            url: slugCheckUrl,
            data: {
                _token: $('meta[name=token]').attr('content'),
                slug: $('#slug').val(),
            },
            success: function(data) {

            },
            error: function(data) {
                swal(data.responseJSON.message, {
                    icon: "warning",
                });
                $('#slug').val(data.responseJSON.slug);
            }
        });
    });
    $('#knowledgebase_form').on('submit', function() {
        var description = quill.root.innerHTML;
        $('#description_html').val(description);
        $('#knowledgebase_form')[0].submit();
    });
</script>
@endpush