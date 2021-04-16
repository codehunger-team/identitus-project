<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="token" content="{!! csrf_token() !!}">
    <title>@yield('seo_title', 'Identitius')</title>
    {{--  Tell the browser to be responsive to screen width  --}}
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{--  WYSIWYG  --}}
    <link rel="stylesheet" type="text/css"
          href="{{ asset('../resources/assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    {{--  iCheck  --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('../resources/assets/admin/plugins/iCheck/flat/blue.css') }}">
    {{--  dataTables  --}}
    {{--    <link rel="stylesheet" type="text/css"--}}
    {{--        href="{{ asset('../resources/assets/admin/plugins/datatables/dataTables.bootstrap.css') }}">--}}
    {{-- - datetime picker  --}}
    {{--    <link rel="stylesheet" type="text/css"--}}
    {{--        href="{{ asset('../resources/assets/admin/plugins/bootstrap-datetimepicker/datetimepicker.min.css') }}">--}}
    {{--  colorPicker  --}}
    <link rel="stylesheet" type="text/css"
          href="{{ asset('../resources/assets/admin/plugins/colorpicker/bootstrap-colorpicker.min.css') }}">
    {{--  select2  --}}
    <link rel="stylesheet" type="text/css"
          href="{{ asset('../resources/assets/admin/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{--  blueimp Gallery styles  --}}
    <link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('../resources/assets/admin/css/style.css') }}">
    {{--  jQuery JS 2.1.4  --}}
    <script src="{{ asset('../resources/assets/admin/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    {{--  morris.js  --}}
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    {{--  country list  --}}
    <script src="{{ asset('../resources/assets/admin/js/countries.js') }}"></script>
    {{--  select2  --}}
    <script src="{{ asset('../resources/assets/admin/plugins/select2/select2.min.js') }}"></script>
    {{-- -Date time picker --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
    <script src="{{ asset('../resources/assets/admin/plugins/bootstrap-datetimepicker/datetimepicker.min.js') }}">
    </script>
    <script>
        $(function () {

            $(".js-example-basic-multiple").select2({
                multiple: true,
                tags: true,
            });



            $('#datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD',
            });

        });

    </script>
    <style></style>
</head>
