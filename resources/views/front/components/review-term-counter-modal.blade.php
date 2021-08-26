<div class="modal fade" id="counterModal" tabindex="-1" aria-labelledby="counterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="counterModalLabel">Counter Offer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('counter')}}" method="post" id="counter_update" enctype="multipart/form-data">
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
                                    placeholder="First Payment" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="periodPayments">Period Payments ($)</label>
                                <input type="text" name="period_payment" id="periodPayment" class="form-control"
                                    placeholder="$500" required>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="periods">Periods <span class="text-danger">*</span></label>
                                <div class="input-group mb-2">
                                    <input type="number" name="number_of_periods" class="form-control" id="period"
                                        placeholder="Periods" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="optionPurchasePrice">Option Purchase Price ($)</label>
                                <input type="number" name="option_purchase_price" class="form-control" id="option-purchase-price"
                                    placeholder="$50,000" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn lease-counter btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
