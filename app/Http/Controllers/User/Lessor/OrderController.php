<?php

namespace App\Http\Controllers\User\Lessor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Order;
use App\Models\Domain;

class OrderController extends Controller
{   
    /**
     * Lessor Seller Order
     * 
     */
    public function userSellerOrders()
    {

        $userEmail = Auth::user()->email;
        $userId = Auth::id();

        $orders = Order::where('email', '!=', $userEmail)
            ->orderBy('id', 'DESC')->get();

        $sellerDomain = Domain::where('user_id', $userId)->get();

        foreach ($sellerDomain as $key => $data) {
            foreach ($orders as $order) {
                $decodedOrder = json_decode($order->order_contents);
                foreach ($decodedOrder as $orderData) {
                    if ($data->domain == $orderData->name && $order->order_status == 'Paid') {
                        $sellerOrders[$order->order_date][$key]['price'] = $orderData->price;
                        $sellerOrders[$order->order_date][$key]['order_id'] = $order->id;
                        $sellerOrders[$order->order_date][$key]['domain_name'] = $orderData->name;
                        $sellerOrders[$order->order_date][$key]['order_status'] = $order->order_status;
                        $sellerOrders[$order->order_date][$key]['order_date'] = $order->order_date;
                        $sellerOrders[$order->order_date][$key]['customer'] = $order->customer;
                        $sellerOrders[$order->order_date][$key]['email'] = $order->email;
                        $monthlyOrders['price'][] = $orderData->price;

                        if ($order->order_date >= \Carbon\Carbon::now()->startOfMonth()) {
                            $monthCount[] = $order->order_date;
                            $monthPrice[] = $orderData->price;
                            $dt = new \DateTime($order->order_date);
                            $convertedDate = $dt->format('Y-m-d');
                            $sellerMonthlyOrders[$convertedDate][$key]['price'] = $orderData->price;
                        }
                    }
                }
            }
        }

        $customerWiseOrder = [];

        if (isset($sellerOrders)) {
            foreach ($sellerOrders as $orderDate => $sellerOrder) {

                $customerWiseOrder[$orderDate]['price'] = null;

                foreach ($sellerOrder as $orderDetail) {
                    $customerWiseOrder[$orderDate]['customer'] = $orderDetail['customer'];
                    $customerWiseOrder[$orderDate]['price'] += $orderDetail['price'];
                    $customerWiseOrder[$orderDate]['order_status'] = $orderDetail['order_status'];
                    $customerWiseOrder[$orderDate]['order_date'] = $orderDetail['order_date'];
                    $customerWiseOrder[$orderDate]['order_id'] = $orderDetail['order_id'];
                    $customerWiseOrder[$orderDate]['email'] = $orderDetail['email'];
                }

            }
        }

        if (empty($sellerMonthlyOrders)) {
            $sellerMonthlyOrders = [];
            $graph = [];
            $monthCount = [];
            $monthPrice = [];

        }

        foreach ($sellerMonthlyOrders as $sellerOrderDate => $sellerOrderData) {
            $graph[$sellerOrderDate] = null;
            foreach ($sellerOrderData as $orderDetailData) {
                $graph[$sellerOrderDate] += $orderDetailData['price'];
            }

        }

        $days = collect($graph);
        $mtd_count = count($monthCount);
        $earnings_mtd = array_sum($monthPrice);
        if (isset($monthlyOrders)) {
            $all_time_earnings = array_sum($monthlyOrders['price']);
        } else {
            $all_time_earnings = 0;
        }

        if (isset($sellerOrders)) {
            $all_time_sales = count($sellerOrders);
        } else {
            $all_time_sales = 0;
        }

        // finally, return the view
        return view('user.lessor.order.seller')
            ->with('active', 'seller-order')
            ->with('orders', $customerWiseOrder)
            ->with('mtd_count', $mtd_count)
            ->with('earnings_mtd', $earnings_mtd)
            ->with('all_time_sales', $all_time_sales)
            ->with('all_time_earnings', $all_time_earnings)
            ->with('earnings_30_days', $days);

    }

    /**
     * View Lessor Seller Order
     * 
     */
    public function userSellerViewOrders($orderId)
    {

        $orders = Order::where('id', $orderId)->get();
        $order = $orders->first();
        $userId = Auth::id();

        $sellerDomain = Domain::where('user_id', $userId)->get();

        foreach ($sellerDomain as $key => $data) {
            foreach ($orders as $order) {
                $decodedOrder = json_decode($order->order_contents);
                foreach ($decodedOrder as $orderData) {
                    if ($data->domain == $orderData->name && $order->order_status == 'Paid') {
                        $sellerOrders[$order->order_date][$key]['price'] = $orderData->price;
                        $sellerOrders[$order->order_date][$key]['order_id'] = $order->id;
                        $sellerOrders[$order->order_date][$key]['domain_name'] = $orderData->name;
                        $sellerOrders[$order->order_date][$key]['order_status'] = $order->order_status;
                        $sellerOrders[$order->order_date][$key]['order_date'] = $order->order_date;
                        $sellerOrders[$order->order_date][$key]['customer'] = $order->customer;
                        $sellerOrders[$order->order_date][$key]['email'] = $order->email;
                        $sellerOrders[$order->order_date][$key]['domain_id'] = $orderData->id;
                    }
                }
            }
        }
        return view('user.lessor.order.view', compact('sellerOrders', 'order'));
    }
}
