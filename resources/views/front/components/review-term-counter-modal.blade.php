<div class="modal fade" id="counterModal" tabindex="-1" aria-labelledby="counterModalLabel" aria-hidden="true">
    <div class="modal-dialog"> 
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="counterModalLabel">Counter Offer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" class="counter-form">
                @csrf
                @if(count($errors))
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.
                    <br />
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="counter-id" name="contract_id">
                    <input type="hidden" id="lessor-id" name="lessor_id">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="firstPayment">First Payment ($)</label>
                                <input type="number" name="first_payment" class="form-control" id="first-payment"
                                     required>
                                <span class="text-danger">
                                    <p id="first-payment-error"></p>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="periodPayments">Period Payments ($)</label>
                                <input type="text" name="period_payment" id="periodPayment" class="form-control"
                                     required>
                                    <span class="text-danger">
                                        <p id="periodPayment-error"></p>
                                    </span>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="periods">Periods <span class="text-danger">*</span></label>
                                <div class="input-group mb-2">
                                    <input type="number" name="number_of_periods" class="form-control" id="period"
                                        required>
                                </div>
                                <span class="text-danger">
                                    <p id="period-error"></p>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="optionPurchasePrice">Option Purchase Price ($)</label>
                                <input type="number" name="option_purchase_price" class="form-control" id="option-purchase-price"
                                    required>
                                <span class="text-danger">
                                    <p id="option-purchase-price-error"></p>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="counter-form-submit" class="btn lease-counter btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .border-danger {
        border :"2px solid red";
    }
</style>
