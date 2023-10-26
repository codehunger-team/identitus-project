@push('scripts')
<script>
    const knowledgebaseSidebarSearchEndpoint = '{{ route("frontknowledgebase.subCategory.search") }}';
</script>
<script>
    $(document).on('keyup', '#knowledgebase_search', function() {
        if ($(this).val() == '') {
            return;
        }
        $.ajax({
            method: 'POST',
            url: knowledgebaseSidebarSearchEndpoint,
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                q: $(this).val(),
            },
            success: function(data) {
                $('#searchList').html(data);
                $('#searchList').fadeIn();
            },
            error: function(data) {
                console.log(data);
            }
        })
    });
    document.querySelector('.content').addEventListener('click', () => {
        $('#searchList').fadeOut();
        $('#searchList').html('');
    });
</script>
@endpush