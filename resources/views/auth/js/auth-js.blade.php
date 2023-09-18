<script>
    function validate() {
        if ($("#agreement-checkbox").prop('checked') != true || $("#tos-checkbox").prop('checked') != true) {
            alert("Please tick out the agreement");
            return false;
        }
    }

    function rejectAgreement(type) {
        switch (type) {
            case 'close-tos':
                $('#tos-checkbox').prop('checked', false);
                break;
            case 'close-agreement':
                $('#agreement-checkbox').prop('checked', false);
                break;
        }

    }

    function closeTheModal() {
        $('#agreement-popup').modal('hide');
        $('#tos-popup').modal('hide');
    }

    function readTheAgreement(type) {
        switch (type) {
            case 'tos':
                if ($("#tos-checkbox").prop('checked') == true) {
                    $('#tos-popup').modal('show');
                    loadTermlyPolicy();
                } else {
                    $('#agreement-popup').modal('hide');
                }
                break;
            case 'agreement':
                if ($("#agreement-checkbox").prop('checked') == true) {
                    $('#agreement-popup').modal('show');
                } else {
                    $('#agreement-popup').modal('hide');
                }
                break;
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

    $(document).ready(function () {
        $("#password-confirm").keyup(checkPasswordMatch);
    });
    $("#email").on('keyup', function () {
        if (isEmail($("#email").val())) {
            $.ajax({
                type: 'POST',
                url: '{{ route('register.check.account') }}',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    email: $("#email").val(),
                },
                success: function (data) {
                    if (data.exists) {
                        $('#email').addClass('is-invalid');
                        $('.duplicate-email').show();
                        $('.register-submit-button').attr('disabled', true);
                    } else {
                        $('#email').removeClass('is-invalid');
                        $('.register-submit-button').removeAttr('disabled');
                        $('.duplicate-email').hide();
                    }
                },
                error: function (error) {
                    alert(error.responseJSON.message);
                }
            });
        }
    });

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

</script>