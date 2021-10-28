@if(session('msg'))
    <div id="message">
        <div style="padding: 5px;">
            <div id="inner-message" class="alert alert-error">
                <div class="alert alert-primary alert-dismissible  float-end notify" role="alert">
                    {!! session('msg') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
@endif
