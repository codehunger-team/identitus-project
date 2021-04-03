<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // if remove
        if ($removeId = \Request::get('remove')) {

            // remove from db
            $d = Order::findOrFail($removeId);
            $d->delete();

            return redirect('admin')->with('msg', 'Successfully removed order "#' . $d->id . '"');
        }

        // orders ( list all )
        $orders = Order::orderBy('id', 'DESC')->get();

        // earnings & sales MTD
        $mtd_count = Order::where('order_date', '>=', \Carbon\Carbon::now()->startOfMonth())
            ->where('order_status', '=', 'Paid')
            ->count();
        $earnings_mtd = Order::where('order_date', '>=', \Carbon\Carbon::now()->startOfMonth())
            ->where('order_status', '=', 'Paid')
            ->sum('total');

        // earnings & sales ALL TIME
        $all_time_earnings = Order::where('order_status', '=', 'Paid')->sum('total');
        $all_time_sales = Order::where('order_status', '=', 'Paid')->count();

        // earnings past 30 days
        $date = \Carbon\Carbon::parse('31 days ago');

        $days = Order::select([
            \DB::raw('DATE(`order_date`) as `date`'),
            \DB::raw('SUM(`total`) as `total`'),
        ])
            ->where('order_date', '>', $date)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->pluck('total', 'date');

        // finally, return the view
        return view('admin.dashboard')
            ->with('active', 'dashboard')
            ->with('orders', $orders)
            ->with('mtd_count', $mtd_count)
            ->with('earnings_mtd', $earnings_mtd)
            ->with('all_time_sales', $all_time_sales)
            ->with('all_time_earnings', $all_time_earnings)
            ->with('earnings_30_days', $days);

    }

    // categories
    public function categories_overview()
    {

        // if remove
        if ($removeId = \Request::get('remove')) {

            // remove from db
            $d = Category::findOrFail($removeId);
            $d->delete();

            return redirect('admin/categories')->with('msg', 'Successfully removed category "' . $d->catname . '"');
        }

        // if update
        $catname = '';
        $catID = '';
        if ($updateCat = \Request::get('update')) {

            // find category
            $c = Category::findOrFail($updateCat);
            $catname = $c->catname;
            $catID = $c->id;

        }

        $categories = Category::orderBy('catname', 'ASC')->get();

        return view('admin.category.categories')
            ->with('active', 'categories')
            ->with('categories', $categories)
            ->with('catname', $catname)
            ->with('catID', $catID);

    }

    // add category
    public function add_category(Request $r)
    {

        $this->validate($r, ['catname' => 'required']);

        $c = new Category;
        $c->catname = $r->catname;
        $c->save();

        return redirect('admin/categories')->with('msg', 'Category successfully created.');

    }

    // update category
    public function update_category(Request $r)
    {
        $this->validate($r, ['catname' => 'required']);

        $c = Category::findOrFail($r->id);
        $c->catname = $r->catname;
        $c->save();

        return redirect('admin/categories')->with('msg', 'Category successfully updated.');

    }
}
