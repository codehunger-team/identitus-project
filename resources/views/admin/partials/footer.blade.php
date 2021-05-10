{{-- <script src="{{ asset('../resources/assets/admin/plugins/jQueryUI/jquery-ui.min.js') }}"></script> --}}
{{--  Bootstrap 3.3.5  --}}
{{-- <script src="{{ asset('../resources/assets/admin/bootstrap/js/bootstrap.min.js') }}"></script> --}}
{{--  wysiwyg  --}}
{{--  iCheck  --}}
{{-- <script src="{{ asset('../resources/assets/admin/plugins/iCheck/icheck.min.js') }}"></script> --}}
{{--  dataTables  --}}
{{-- <script src="{{ asset('../resources/assets/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script> --}}
{{-- <script src="{{ asset('../resources/assets/admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script> --}}
{{--  AdminLTE App  --}}
{{-- <script src="{{ asset('../resources/assets/admin/js/app.min.js') }}"></script> --}}
{{--  laravel.js  --}}
{{-- <script src="{{ asset('../resources/assets/js/laravel.js') }}"></script> --}}
{{--  colorPicker  --}}
{{-- <script src="{{ asset('../resources/assets/admin/plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script> --}}
{{-- <script src="{{ asset('js/app.js') }}"></script> --}}
{{-- <script src="{{ asset('../resources/assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}">
</script> --}}
{{-- <script src="http://folio.codehunger.in/resources/assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
      <script src="http://folio.codehunger.in/resources/assets/admin/plugins/datatables/dataTables.bootstrap.min.js"></script> --}}
<script>
    $(document).ready(function ($) {
        $('.dataTable').dataTable();
        // alert('hello');
        // $(".sortableUI tbody").sortable({
        //     update: function () {
        //         var order = $(".sortableUI tbody").sortable('toArray');
        //         $.get('/admin/navigation-ajax-sort', {
        //             'navi_order': order
        //         }, function (r) {
        //             $('.order-result').show();
        //         });
        //     }
        // });

        // $(".sortableUI").disableSelection();
        // $('input').iCheck({
        //     checkboxClass: 'icheckbox_flat-blue',
        //     radioClass: 'icheckbox_flat-blue',
        //     increaseArea: '20%' // optional
        // });
      


    });



    $(document).ready(function () {
        var periodPayments = parseInt($('#periodPayments').val());
        var periods = parseInt($('#periods').val());
        var firstPayment = parseInt($('#firstPayment').val());
        var leaseTotal = firstPayment + periods * periodPayments;
        $('#leaseTotal').val(leaseTotal);
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

</script>

