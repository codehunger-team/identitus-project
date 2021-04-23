<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="token" content="{!! csrf_token() !!}">
    <title>@yield('seo_title', 'Domain.Trader')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ asset('../resources/assets/admin/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('../resources/assets/admin/css/AdminLTE.min.css') }}">
    <!-- WYSIWYG -->
    <link rel="stylesheet" type="text/css" href="{{ asset('../resources/assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../resources/assets/admin/css/skins/skin-black.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" type="text/css" href="{{ asset('../resources/assets/admin/plugins/iCheck/flat/blue.css') }}">
    <!-- dataTables -->
    <link rel="stylesheet" type="text/css" href="{{ asset('../resources/assets/admin/plugins/datatables/dataTables.bootstrap.css') }}">
    <!-- colorPicker -->
    <link rel="stylesheet" type="text/css" href="{{ asset('../resources/assets/admin/plugins/colorpicker/bootstrap-colorpicker.min.css') }}">
    <!-- select2 -->
    <link rel="stylesheet" type="text/css" href="{{ asset('../resources/assets/admin/plugins/select2/select2.min.css') }}">
    <!--- datetime picker --->
    <link rel="stylesheet" type="text/css" href="{{ asset('../resources/assets/admin/plugins/bootstrap-datetimepicker/datetimepicker.min.css') }}">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <!-- blueimp Gallery styles -->
    <link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('../resources/assets/admin/css/style.css') }}">
    <!-- jQuery JS 2.1.4 -->
    <script src="{{ asset('../resources/assets/admin/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <!-- morris.js -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <!-- country list -->
    <script src="{{ asset('../resources/assets/admin/js/countries.js') }}"></script>
    <!-- select2 -->
    <script src="{{ asset('../resources/assets/admin/plugins/select2/select2.min.js') }}"></script>
    <!---Date time picker--->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
	  <script src="{{ asset('../resources/assets/admin/plugins/bootstrap-datetimepicker/datetimepicker.min.js') }}"></script>
    
    <script>
      $(function() {
        $(".js-example-basic-multiple").select2({
              multiple: true,
              tags:true,
        });
      });

      //date time picker js
      $(function () {
        $('#datetimepicker').datetimepicker({
          format: 'YYYY-MM-DD',
          });
      });
    </script>
  </head>
  <body class="hold-transition skin-black sidebar-mini">
    <div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="/" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>I</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Identitius</b></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <li class="header">USER MENU</li>
            <!-- Optionally, you can add icons to the links -->
              <li @if(isset($active) AND ($active == 'user')) class="active" @endif>
                <a href="{{route('user.profile')}}"><i class="fa fa-user"></i> <span>Profile</span></a>
              </li>

            <!-- Functions as Lessee/Buyer -->
              <li @if(isset($active) AND ($active == 'orders')) class="active" @endif>
                <a href="{{route('user.orders')}}"><i class="fa fa-shopping-cart "></i> <span>Orders</span></a>
              </li>

              <li @if(isset($active) AND ($active == 'rental-agreement')) class="active" @endif>
                <a href="{{route('user.rental.agreement')}}"><i class="fa fa-credit-card" aria-hidden="true"></i> <span>Rental Agreements</span></a>
              </li>

            <!-- Functions as Lessor/Seller -->
            @if (Auth::user()->is_vendor == 'yes')
            <li class="header">Seller + Lessor Tools</li>

            <!-- These three menu items need to be user.specific -->
              <li @if(isset($active) AND ($active == 'seller-order')) class="active" @endif>
                <a href="{{route('user.seller.orders')}}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Orders</span></a>
              </li>
              <li @if(isset($active) AND ($active == 'domains')) class="active" @endif>
                <a href="{{route('user.domains')}}"><i class="fa fa-globe"></i> <span>Owned Domains</span></a>
              </li>
              <li @if(isset($active) AND ($active == 'active-lease')) class="active" @endif>
                <a href="{{route('user.active.lease')}}"><i class="fa fa-money" aria-hidden="true"></i> <span>Active Lease</span></a>
              </li>
              <li @if(isset($active) AND ($active == 'inactive-lease')) class="active" @endif>
                <a href="{{route('user.inactive.lease')}}">
                  <i class="fa fa-ban" aria-hidden="true"></i> <span>Inactive Lease</span></a>
              </li>
              <li @if(isset($active) AND ($active == 'bank-details')) class="active" @endif>
                <a href="{{route('user.stripe-connect')}}">
                  <i class="fa fa-university" aria-hidden="true"></i> <span>Connect Stripe</span></a>
              </li>
            @endif
            <li>
              <a href="{{route('user.logout')}}"><i class="fa fa-power-off"></i> <span>Log Out</span></a>
            </li>
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <div class="container">
        <hr />
        

          @if( session('msg') )
          <div class="alert alert-info alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-info"></i> Alert!</h4>
          {!! session('msg') !!}
          </div>
          @endif

          @if (count($errors) > 0)
          <div class="alert alert-danger alert-dismissible">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
          @endif

          @yield('extra_top') 

          <div class="box">
            <div class="box-header with-border">@yield('section_title', 'Section Title')</div>
            <div class="box-body">
            @yield('section_body', 'Body')
            </div>
            <div class="box-footer"></div>
          </div>

          @yield('extra_bottom') 
        
        </div><!-- /.content -->
      </div><!-- /.content-wrapper -->

    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->
    <!-- jQuery UI -->
    <script src="{{ asset('../resources/assets/admin/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{ asset('../resources/assets/admin/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- wysiwyg -->
    <script src="{{ asset('../resources/assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset('../resources/assets/admin/plugins/iCheck/icheck.min.js') }}"></script>
    <!-- dataTables -->
    <script src="{{ asset('../resources/assets/admin/plugins/datatables/jQuery.dataTables.min.js') }}"></script>
    <script src="{{ asset('../resources/assets/admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('../resources/assets/admin/js/app.min.js') }}"></script>
    <!-- laravel.js -->
    {{-- <script src="{{ asset('../resources/assets/js/laravel.js') }}"></script> --}}
    <!-- colorPicker -->
    <script src="{{ asset('../resources/assets/admin/plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>

    <script>
    jQuery(document).ready(function($){
      $(".textarea").wysihtml5();
      $( ".sortableUI tbody" ).sortable({
        update: function() {
            var order = $( ".sortableUI tbody" ).sortable('toArray');
            $.get('/admin/navigation-ajax-sort', { 'navi_order': order }, function(r) {
              $('.order-result').show();
            });
        }
      });
      $( ".sortableUI" ).disableSelection();
      $('input').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'icheckbox_flat-blue',
        increaseArea: '20%' // optional
      });
      $('.dataTable').dataTable();
      $('.my-colorpicker2').colorpicker();

    });

    //Js for password confirmation
    $('#new_password, #confirm_new_password').on('keyup', function () {
      if ($('#new_password').val() == $('#confirm_new_password').val()) {
        $('#message').html('Matched').css('color', 'green');
      } else 
        $('#message').html('Not Matched').css('color', 'red');
    });

    //Js for lease calculation
    $(document).ready(function(){
        var periodPayments = parseInt($('#periodPayments').val());
        var periods = parseInt($('#periods').val());
        var firstPayment = parseInt($('#firstPayment').val());
        var leaseTotal = firstPayment + periods * periodPayments;
        $('#leaseTotal').val(leaseTotal);
    }); 

    $(document).on('keyup','#firstPayment,#periods,#periodPayments',function(event){
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
    /******end of js***************************/

    /** check for account number confimation ****/
    $('.account_number, .confirm_account_number').on('keyup', function () {
      if ($('.account_number').val() == $('.confirm_account_number').val()) {
        $('.alert-message').html('');
      } else 
        $('.alert-message').html('Account and confirm account number doesn\'t match').css('color', 'red');
    });
    </script>
  </body>
</html>
