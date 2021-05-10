<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Navi;
use App\Models\Option;
use App\Models\Order;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        $c = Category::findOrFail($r->catID);
        $c->catname = $r->catname;
        $c->save();

        return redirect('admin/categories')->with('msg', 'Category successfully updated.');

    }

    // pages controller
    public function pages()
    {
        // get existent pages
        $pages = Page::all();
        return view('admin.page.pages')->with('pages', $pages)
            ->with('active', 'pages');
    }

    // create a page
    public function create_page(Request $r)
    {
        // validate form entries
        $this->validate($r, ['page_title' => 'unique:pages|required']);
        // save page
        $page = new Page;
        $page->page_title = $r->page_title;
        $page->page_slug = Str::slug($r->page_title);
        $page->page_content = $r->page_content;
        $page->save();

        return redirect()->route('admin.cms')->with('msg', 'Page successfully created');

    }

    //edit page
    public function edit_page($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.page.update-page')->with('p', $page)->with('active', 'pages');
    }

    //update page
    public function update_page($id)
    {
        $page = Page::findOrFail($id);
        $page->page_title = \Request::get('page_title');
        $page->page_content = \Request::get('page_content');
        $page->save();
        return redirect('admin/cms-edit/' . $id)->with('msg', 'Page successfully created');
    }

    //delete page
    public function delete_page($id)
    {
        if ($id != 1) {
            Page::destroy($id);
            $msg = 'Page successfully removed';
        } else {
            $msg = 'You cannot remove homepage sorry.';
        }
        return redirect()->route('admin.cms')->with('msg', $msg);
    }

    // navigation controller
    public function navigation()
    {
        // get existent menu items
        $navi_order = Option::get_option('navi_order');

        if ($navi_order && !empty($navi_order)) {
            $navi = Navi::orderByRaw("FIELD(id, $navi_order)")->get();
        } else {
            $navi = Navi::all();
        }

        return view('admin.navigation.navigation')->with('navi', $navi)
            ->with('active', 'navi');

    }

    // create navigation item
    public function navigation_save(Request $r)
    {
        // save and redirect
        Navi::create($r->except('sb_navi', '_token'));
        return redirect('admin/navigation')->with('msg', 'Item successfully added to navigation');

    }

    //edit navigation
    public function navigation_edit($id)
    {
        $nav_item = Navi::findOrFail($id);
        return view('admin.navigation.navigation-edit')->with('n', $nav_item);
    }

    //update navigation
    public function navigation_update($id)
    {
        $nav_item = Navi::findOrFail($id);
        $nav_item->title = request('title');
        $nav_item->url = request('url');
        $nav_item->target = request('target');
        $nav_item->save();
        return redirect('admin/navigation')->with('msg', 'Menu item successfully saved');
    }

    //delete navigation
    public function navigation_delete()
    {
        Navi::destroy($id);
        return redirect('admin/navigation')->with('msg', 'Menu item successfully removed');
    }

    //ajax sort
    public function navigation_ajax_sort()
    {
        $navi_order = implode(',', request('navi_order'));
        Option::update_option('navi_order', $navi_order);
        return "Order successfully saved";
    }

    //configuration overview
    public function configuration_overview()
    {
        return view('admin.configuration.configuration')->with('active', 'config');
    }

    //configuration show
    public function configuration_show()
    {
        $options = request()->except('_token', 'sb_settings');
        // save options
        foreach ($options as $name => $value) {
            Option::update_option($name, $value);
        }

        // logo updated?
        $headImage = '';
        if (request()->hasFile('homepage_header_image')) {
            $ext = request()->file('homepage_header_image')->getClientOriginalExtension();
            $destinationPath = base_path() . '/resources/assets/images/';
            $fileName = uniqid(rand()) . '.' . $ext;
            request()->file('homepage_header_image')->move($destinationPath, $fileName);
            $headImage = Option::update_option('homepage_header_image', '/resources/assets/images/' . $fileName);
        }

        return redirect('admin/configuration')->with('msg', 'Configuration settings successfully saved!');
    }

    // view order info
    public function view_order($id)
    {
        $order = Order::where('id', $id)->first();
        // order contents unserialize
        $order_content = json_decode($order->order_contents);

        // return view
        return view('admin.order.view')
            ->with('active', 'dashboard')
            ->with('order', $order)
            ->with('order_content', $order_content);

    }

    //delete order
    public function delete_order($id)
    {
        Order::where('id', $id)->delete();
        return redirect()->back()->with('msg', 'Order successfully deleted!');
    }

    public function logout()
    {
        \Session::flush();
        return redirect('/login');
    }
}
