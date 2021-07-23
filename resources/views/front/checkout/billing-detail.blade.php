<div class="card">
    <div class="card-header">
        <label for="card-element">
            BILLING INFORMATION
        </label>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" readonly name="name" class="form-control custname" value="{{Auth::user()->name ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" readonly name="email" class="form-control email" value="{{Auth::user()->email ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Business Address Line 1</label>
                    <input type="text" readonly name="address_line1" class="form-control address_line1"
                        value="{{Auth::user()->street_1 ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Business Address Line 2</label>
                    <input type="text" readonly name="address_line2" class="form-control address_line2"
                        value="{{Auth::user()->street_2 ?? ''}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>City</label>
                    <input type="text" readonly name="city" class="form-control city" value="{{Auth::user()->city ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>State (if applicable)</label>
                    <input type="text" readonly name="state" class="form-control state" value="{{Auth::user()->state ?? ''}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Zip Code</label>
                    <input type="text" readonly name="zip_code" class="form-control zip_code" value="{{Auth::user()->zip ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Country</label>
                    <input type="text" readonly name="country" class="form-control zip_code" value="{{Auth::user()->country ?? ''}}">
                </div>
            </div>
        </div>
    </div>
</div>