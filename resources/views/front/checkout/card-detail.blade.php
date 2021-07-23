<div class="card">
    <form action="{{route('checkout.credit.card')}}" method="post" id="payment-form">
        @csrf
        <div class="form-group">
            <div class="card-header">
                <label for="card-element">
                    Enter your credit card information
                </label>
            </div>
            <div class="card-body">
                <div id="card-element">
                    <!-- A Stripe Element will be inserted here. -->
                </div>
                <!-- Used to display form errors. -->
                <div id="card-errors" role="alert"></div>
                <input type="hidden" name="plan" value="" />
            </div>
        </div>
        <div class="card-footer">
            <button id="card-button" class="btn btn-primary submit-btn" type="submit"
                data-secret="{{ $intent }}"> Pay </button>
        </div>
    </form>
</div>