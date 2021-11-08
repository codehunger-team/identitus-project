<script src="{{ asset('js/app.js') }}" ></script>
<script src="{{ asset('js/raphel.min.js') }}" ></script>
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js" ></script>

<script>
    $(function() {
        $('.dataTable').dataTable();

        $(".js-example-basic-multiple").select2({
            multiple: true,
            tags: true,
        });

        $('#datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD',
        });

        var periodPayments = parseInt($('#periodPayments').val());
        var periods = parseInt($('#periods').val());
        var firstPayment = parseInt($('#firstPayment').val());
        var leaseTotal = firstPayment + periods * periodPayments;
        $('#leaseTotal').val(leaseTotal);

    });

    $(document).ready(function () {
            $('.sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $('.side-text').toggleClass('hide-show');
            });
        });

    $(document).on('keyup', '#firstPayment,#periods,#periodPayments', function (event) {
        var checkId = event.target.id;
        if (checkId == 'firstPayment') {
            var firstPayment = parseInt(this.value);
            var periods = parseInt($('#periods').val());
            var periodPayments = parseInt($('#periodPayments').val());
        } else if (checkId == 'periods') {
            var periods = parseInt(this.value);
            var firstPayment = parseInt($('#firstPayment').val());
            var periodPayments = parseInt($('#periodPayments').val());
        } else {
            var periodPayments = parseInt(this.value);
            var periods = parseInt($('#periods').val());
            var firstPayment = parseInt($('#firstPayment').val());
        }
        var leaseTotal = firstPayment + periods * periodPayments;
        $('#leaseTotal').val(leaseTotal);
    });

     //Js for password confirmation
     $('#new_password, #confirm_new_password').on('keyup', function () {
      if ($('#new_password').val() === $('#confirm_new_password').val()) {
        $('#message').html('Matched').css('color', 'green');
      } else
        $('#message').html('Not Matched').css('color', 'red');
    });

    // $(document).on('click','.navbar-button',function() {
    //     $('.navbar-button').toggleClass("sidenav-push");
    // });
</script>

