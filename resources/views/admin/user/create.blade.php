@extends('admin.base')

@section('section_title')
<div class="row">
    <div class="col-sm-6">
        <strong>Create User</strong>
    </div>
    <div class="col-sm-6">
        <a href="{{route('admin.users')}}" class="btn btn-primary btn-xs float-right">Back to User's List</a>
    </div>
</div>
@endsection

@section('section_body')
<form method="POST" enctype="multipart/form-data" action="{{route('admin.user.store')}}">
    @csrf
    <div class="card border-0 p-3 shadow my-3">
        <div class="row">
            <div class="card-header border-0 bg-white mb-3">
                <h4 class="text-muted">User Type</h4>
            </div>
            <div class="col-xs-12 col-md-6">
                <label>Choose User Type</label><br />
                <select class="form-select select-user" name="selected_user" aria-label="Default select example" onchange="selectUser()">
                    <option selected>Open this select menu</option>
                    <option value="admin">Admin</option>
                    <option value="customer">Customer</option>
                    <option value="vendor">Vendor</option>
                </select>
            </div>
        </div>
    </div>

    <!--admin form -------->
        @include('admin.user.partial.admin-form-field')
    <!----------------------->

    <!---customer form----->
        @include('admin.user.partial.customer-form-field')
    <!------------------------>
    <div class="col-xs-6">
        <input type="submit" class="btn btn-block btn-primary">
    </div>
</form>

<script>
    $(document).ready(function () { 
        $('.customer-form').addClass('d-none');
        $('.admin-form').addClass('d-none');
    });
    function selectUser() {
        const selectedUser = $('.select-user').find(":selected").val();
        if (selectedUser == 'admin') {
            $('.customer-form').addClass('d-none');
            $('.admin-form').removeClass('d-none');
            $(".customer-form-value").attr("disabled", true);
            $(".admin-form-value").attr("disabled", false);
        } else if(selectedUser == 'customer') {
            $('.user-heading').html('Customer')
            $('.admin-form').addClass('d-none');
            $('.customer-form').removeClass('d-none');
            $(".admin-form-value").attr("disabled", true);
            $(".customer-form-value").attr("disabled", false);
        } else if(selectedUser == 'vendor') {
            $('.user-heading').html('Vendor')
            $('.admin-form').addClass('d-none');
            $('.customer-form').removeClass('d-none');
            $(".admin-form-value").attr("disabled", true);
            $(".customer-form-value").attr("disabled", false);
        } 
    }
    function checkPasswordMatch() {
        var password = $("#password").val();
        var confirmPassword = $("#password-confirm").val();
        var regularExpression = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9_])/;

        if (confirmPassword.length < 8 && !regularExpression.test(confirmPassword)) {
            $("#divCheckPasswordMatch").html("Password guidelines doesn't match");
            $('#divCheckPasswordMatch').addClass('text-danger');
            $('#divCheckPasswordMatch').removeClass('text-success');
            $('.register-submit-button').addClass('disabled');
        } else {
            if (password != confirmPassword) {
                $("#divCheckPasswordMatch").html("Passwords do not match!");
                $('#divCheckPasswordMatch').addClass('text-danger');
                $('#divCheckPasswordMatch').removeClass('text-success');
                $('.register-submit-button').addClass('disabled');
            } else {
                $("#divCheckPasswordMatch").html("Passwords match.");
                $('.register-submit-button').removeClass('disabled');
                $('#divCheckPasswordMatch').addClass('text-success');
                $('#divCheckPasswordMatch').removeClass('text-danger');
            }
        }
    }

</script>
@endsection
