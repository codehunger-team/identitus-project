<div class="modal fade" id="profileUpdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Detail</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </button>
        </div>
        <form id="user_update" name="userUpdate">
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                        <label for="email">Name: *</label>
                        <input type="name" class="form-control"  readonly placeholder="Enter name"  required value="{{Auth::user()->name ?? ''}}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                        <label for="email">Email address: *</label>
                        <input type="email" class="form-control" readonly placeholder="Enter email"  required value="{{Auth::user()->email ?? ''}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                        <label for="company">Company: </label>
                        <input type="name" name="company" class="form-control" placeholder="Enter company name" value="{{Auth::user()->company ?? ''}}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="phone">Phone: *</label>
                        <input type="number" name="phone" class="form-control" placeholder="Enter number" value="{{Auth::user()->phone ?? ''}}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                        <label for="country">Country: *</label>
                        <input type="name" name="country" class="form-control" placeholder="Enter country name" value="{{Auth::user()->country ?? ''}}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                        <label for="city">city: *</label>
                        <input type="name" name="city" class="form-control" placeholder="Enter city name" value="{{Auth::user()->city ?? ''}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                        <label for="phone">State: *</label>
                        <input type="text" name="state" class="form-control" placeholder="Enter state name" value="{{Auth::user()->state ?? ''}}"  required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                        <label for="street-1">Street 1: *</label>
                        <input type="text" name="street_1" class="form-control" placeholder="Enter street-1" value="{{Auth::user()->street_1 ?? ''}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                        <label for="street-2">Street 2: </label>
                        <input type="text" name="street_2" class="form-control" placeholder="Enter street-2"  required value="{{Auth::user()->street_2 ?? ''}}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                        <label for="phone">ZIP: *</label>
                        <input type="number" name="zip" class="form-control" placeholder="Enter ZIP code"  required value="{{Auth::user()->zip ?? ''}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" value="enter / update" class="btn btn-primary" id="update_btn">
                <button type="button" class="btn btn-secondary" id="update" data-bs-dismiss="modal">Close</button>
            </div>
        </form>
      </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#update_btn').click(function(e) {
            e.preventDefault();
        var formData = {
                phone:    $('input[name=phone]').val(),
                country:  $('input[name=country]').val(),
                state:    $('input[name=state]').val(),
                city:     $('input[name=city]').val(),
                zip:      $('input[name=zip]').val(),
                street_1: $('input[name=street_1]').val(),
                street_2: $('input[name=street_2]').val(),
                company:  $('input[name=company]').val(),
            }

        $.ajax({
                type: "POST",
                url: "{{route('user.review.update')}}",
                data: {
                    "data" : formData,
                    "_token": "{{ csrf_token() }}",
                },
                dataType: 'json',
                success: function(data) {
                    if (data.error_length == 0 && data.action == 'success') {
                        $('#main').show(1000, function () {
                            setTimeout(function () {
                                $('#main').html(function () {
                                    setTimeout(function () {
                                        $('#main').hide();
                                    }, 0);
                                });
                            }, 2500);
                            $('#profileUpdateModal').modal('hide');
                            window.location.href = "#contract";
                        });
                        }else{
                        printErrorMsg(data.error);
                    }
                }
            });
        });

        function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','inline');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }
    });
</script>