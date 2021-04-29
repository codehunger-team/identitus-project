@extends('admin.base')

@section('section_title')
	<strong>Order Content</strong>
    <a href="{{route('admin.dashboard')}}" class="btn btn-primary btn-xs float-end">Back to Dashboard</a>
@endsection
@section('section_body')
<div class="card mt-5">
    <div class="card-body">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <table class="table table-responsive">
                    <tr class="text-center">
                        <th colspan="2">Order Contact</th>
                    </tr>
                    <tr>
                        <td>Customer Name:</td>   
                        <td>{{ $order->customer }}</td>    
                    <tr>
                    <tr>
                        <td>Customer Email:</td>   
                        <td><a href="mailto:{{ $order->email }}?subject=Order #{{ $order->id }}">
                            {{ $order->email }}
                        </a></td>   
                    </tr>
                </table>
            </div>
            <div class="col-xs-12 col-md-6">
                <table class="table table-responsive">
                    <tr class="text-center">
                        <th colspan="2">Order Info</th>
                    </tr>
                    <tr>
                        <td>Order Status:</td>   
                        <td>{{ $order->order_status}}</td>    
                    <tr>
                    <tr>
                        <td>Total:</td>   
                        <td>${{ number_format( $order->total, 0 ) }}</td>   
                    </tr>
                    <tr>
                        <td>Order Date:</td>   
                        <td>{{ date( 'jS F Y H:i', strtotime( $order->order_date ) ) }}</td>    
                    <tr>
                    <tr>
                        <td>Payment Type:</td>   
                        <td>{{ $order->payment_type }}</td>    
                    <tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="card mt-4">
    <div class="card-body">
        <table class="table dataTable">
            <thead>
                <tr>
                    <th>Domain ID</th>
                    <th>Domain Name</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach( $order_content as $o )
                    <tr>
                        <td>{!! $o->id !!}</td>
                        <td>{{ $o->name }}</td>
                        <td>${{ number_format($o->price,0) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection