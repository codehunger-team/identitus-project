<form action="{{route('domains')}}" method="get">
    <div class="form-row align-items-center">
        <div id="custom-search-input">
            <div class="input-group">
                <input type="text" name="keyword" class="form-control form-control-lg" placeholder="Domain or Keyword"
                    required />
                <span class="input-group-append">
                    <button class="btn btn-primary btn-lg" type="submit"><i class="fas fa-search"></i>
                    </button>
                </span>
            </div>
        </div><!-- ./#custom-search-input -->
    </div>
</form>
