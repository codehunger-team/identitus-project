<form action="{{route('domains')}}" method="get">
    <div id="domainSearch" class="form-row align-items-center">
        <div id="custom-search-input">
            <div class="input-group">
                <input type="text" name="keyword" class="form-control form-control-lg" placeholder="Enter Domain or Keyword" required />
                <span class="input-group-append">
                    <button class="btn btn-primary btn-lg" type="submit"><i class="fas fa-search"></i>
                    </button>
                </span>
            </div>
        </div>
        <div class="search-list">
            <ul class="search-results">
            </ul>
        </div>
    </div>
</form>
@push('styles')
<style>
    .search-results {
        padding: 0;
    }

    .search-result {
        list-style: none;
        padding: 7px;
        background-color: white;
        cursor: pointer;
        font-size: 15px;
        font-weight: 700;
        color: grey;
    }
</style>
@endpush
@push('scripts')
<script>
    $('input[name="keyword"]').keyup(function() {
        $.ajax({
            method: 'GET',
            url: '{{ route("domain.search.typeahead") }}' + '?keyword=' + $('input[name="keyword"]').val(),
            success: function(data) {
                data.data.forEach(element => {
                    $('.search-results').html('');
                    $('.search-results').append('<a href="/'+ element.domain +'"><li class="search-result"><i class="fas fa-search me-2"></i>' + element.domain + '</li></a>');
                });
            },
            error: function(error) {
                console.log(data);
            }
        })
    });
    window.addEventListener('click', function(e) {
        if (document.getElementById('domainSearch').contains(e.target)) {} else {
            $('.search-results').html('');
        }
    });
</script>
@endpush