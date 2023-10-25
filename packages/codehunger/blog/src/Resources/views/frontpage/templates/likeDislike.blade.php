<div class="float-end reactions-container">
    <span data-action="like" class="reaction-button like-button"><b>{{ $reactions['likes'] }}</b> <i class="fa fa-thumbs-up"></i></span>
    <span data-action="dislike" class="reaction-button dislike-button"><b>{{ $reactions['dislikes'] }}</b> <i class="fa fa-thumbs-down"></i></span>
</div>
@push('scripts')
<script>
    const knowledgebaseReactionEndpoint = "{{ route('frontknowledgebase.reaction') }}";
</script>
@endpush