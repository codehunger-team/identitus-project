@extends('user.base')
@section('section_title')
<strong>Orders Overview</strong>
@endsection
@section('section_body')
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <div class="card text-white bg-warning mb-3 shadow">
            <div class="card-body">
                <h3>{{ $mtd_count }}</h3>
                <p>Month to Date Orders</p>
                <div class="icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="card text-white bg-danger mb-3 shadow">
            <div class="card-body">
                <h3>${{ number_format( $earnings_mtd, 0) }}</h3>
                <p>Month to Date Earnings</p>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="card text-white bg-secondary mb-3 shadow">
            <div class="card-body">
                <h3>{{ $all_time_sales }}</h3>
                <p>Total Orders</p>
                <div class="icon">
                    <i class="fa fa-shopping-cart"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="card text-white bg-success mb-3 shadow">
            <div class="card-body">
                <h3>${{ number_format( $all_time_earnings ,0) }}</h3>
                <p>Total Earnings</p>
                <div class="icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border"><strong>Past 30 Days</strong></div>
                <div class="box-body">
                    <!-- LINE CHART -->
                    <div class="chart-responsive">
                        <div class="chart" id="past-30-days" style="height: 300px;"></div>

                        <script>
                            new Morris.Line({
                                // ID of the element in which to draw the chart.
                                element: 'past-30-days',
                                // Chart data records -- each entry in this array corresponds to a point on
                                // the chart.
                                data: [
                                        @if( $earnings_30_days )
                                        @foreach( $earnings_30_days as $date => $earnings )
                                    {
                                        date: '{{ $date }}', value: {{  $earnings }} },
                                        @endforeach
                                        @else
                                    {
                                        date: '{{ date( 'jS F Y' ) }}', value: 0
                                    }
                                    @endif
                                ],
                                // The name of the data record attribute that contains x-values.
                                xkey: 'date',
                                // A list of names of data record attributes that contain y-values.
                                ykeys: ['value'],
                                // Labels for the ykeys -- will be displayed when you hover over the
                                // chart.
                                labels: ['Earnings']
                            });
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card mt-4">
    <div class="card-body">
        @if($orders)
        <table class="table table-striped table-bordered table-responsive dataTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach( $orders as $email => $o )
                <tr>
                    <td>           
                        <a>{!! $o['order_id'] !!}</a>
                    </td>
                    <td>
                        <a>{{ $o['customer'] }}</a>
                    </td>
                    <td>
                        {{ $o['email'] }}
                    </td>

                    <td>
                        ${{ number_format($o['price'], 0) }}
                    </td>

                    <td>
                        {{app('App\Helpers\DateTimeHelper')->ConvertIntoUTC($o['order_date'])}}
                    </td>

                    <td>
                        {{ $o['order_status'] }} <br />
                        <small><em>via</em> 'stripe'</small>
                    </td>

                    <td>
                        <div class="btn-group">
                            <a class="btn btn-warning btn-xs mr-5" href="{{route('user.view.orders',$o['order_id'])}}">
                                <i class="fa fa-eye text-white"></i>
                            </a>
                            <a href="{{route('user.destroy.order',$o['order_id'])}}"
                                onclick="return confirm('Are you sure you want to remove this order from database?');"
                                class="btn btn-danger btn-xs">
                                <i class="fa fa-trash text-white"></i>
                            </a>
                        </div>
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
        @else
         No orders in database.
    @endif
    </div>
</div>
@endsection
