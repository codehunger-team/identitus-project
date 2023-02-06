<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Domain;
use App\Models\Registrar;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;
use Validator;
use App\Http\Controllers\Admin\DocusignController;
use Yajra\DataTables\Facades\DataTables;

class FrontController extends Controller
{
    public function __construct()
    {
        $this->middleware('preventBackHistory');
    }

    // all domains
    public function all_domains(Request $request, DocusignController $docusign)
    {
        $diff_in_hours = docusignHourDifference();

        if ($diff_in_hours > 7) {
            $docusign->refreshToken();
        }

        $userId = NULL;

        if (Auth::check()) {
            $userId = Auth::user()->id;
        }

        $domain_list = Domain::where('domain_status', 'AVAILABLE')->get();


        // append domain age to the list
        $domain_list->map(function ($d) {
            $d->domain_age = Domain::computeAge($d->reg_date, 0);
        });

        // get tlds
        $tlds = Domain::getAvailableExtensions();

        // get categories
        $categories = Category::orderBy('catname', 'ASC')->get();

        // if keyword is set autofill keyword
        $autoKeyword = '';
        $autoSearch = '';

        if ($request->has('keyword')) {
            $autoKeyword = trim(strip_tags($request->get('keyword')));
            $autoSearch = "<script>$(function() { $( '#ajax-search-form' ).trigger('submit'); });</script>";
        }

        // show view
        return view('front.domain-search.all-domains')
            ->with('domains', $domain_list)
            ->with('tlds', $tlds)
            ->with('categories', $categories)
            ->with('autoSearch', $autoSearch)
            ->with('autoKeyword', $autoKeyword);
    }

    /**
     * This function is used to return teh datatable of the Domains page
     * @method POST /ajax/domain_filtering
     * @param Request $request
     * @return Datatable
     */

    public function domain_filtering(Request $request)
    {
        $filters = $request->filters;
        $domains = Domain::where('domain_status', 'AVAILABLE')
            ->when(isset($filters['keyword']) && $filters['keyword'] != null, function ($query) use ($filters) {
                if ($filters['keyword_placement'] == 'contains') {
                    $query->where('domain', 'like', '%' . $filters['keyword'] . '%');
                }
                if ($filters['keyword_placement'] == 'starts_with') {
                    $query->where('domain', 'like', $filters['keyword'] . '%');
                }
                if ($filters['keyword_placement'] == 'ends_with') {
                    $query->where('domain', 'like', '%' . $filters['keyword']);
                }
            })
            ->when(isset($filters['category']) && $filters['category'] != null, function ($query) use ($filters) {
                $query->where('category', $filters['category']);
            })
            ->when(isset($filters['extension']) && $filters['extension'] != null, function ($query) use ($filters) {
                $query->where('domain', 'LIKE', "%" . $filters['extension']);
            })
            ->when(isset($filters['age']) && $filters['age'] != null, function ($query) use ($filters) {
                $from = date('Y-m-d', strtotime('-' . $filters['age'] . 'years'));
                $to = date('Y-m-d');
                $query->whereBetween('reg_date', [$from, $to]);
            })
            ->when(isset($filters['price_from']) && $filters['price_from'] != null && isset($filters['price_to']) && $filters['price_to'] != null, function ($query) use ($filters) {
                $query->whereBetween('pricing', [$filters['price_from'], $filters['price_to']]);
            })
            ->when(isset($filters['char_to']) && $filters['char_to'] != null && $filters['char_to'] != 'ALL', function ($query) use ($filters) {
                $query->whereRaw('LENGTH(domain) > ' . $filters['char_to']);
            });
        return DataTables::of($domains)
            ->addIndexColumn()
            ->addColumn('monthly_lease', function ($query) {
                return 123;
            })
            ->addColumn('options', function ($query) {
                $action = '';
                if (isset($query->contract->period_payment)) {
                    $action .= '<li><a href="' . route('review.terms', $query->domain) . '" class="dropdown-item">Lease Now</a></li>';
                };
                $action .=  '<div class="dropdown"> <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="buy" data-bs-toggle="dropdown" aria-expanded="false"> Get </a> <ul class="dropdown-menu" aria-labelledby="buy"><li><a href="' . route('ajax.add-to-cart.buy', $query->domain) . '" class="dropdown-item">Buy Now</a></li> </ul> </div>';
                return $action;
            })
            ->rawColumns(['options', 'monthly_lease'])
            ->make(true);
    }

    /**
     * Update User.
     *
     */
    public function user_update(Request $request)
    {
        $validator = Validator::make($request->data, [
            'phone' => 'required|numeric|digits:10',
            'country' => 'required',
            'city' => 'required',
            'state' => 'required',
            'street_1' => 'required',
            'zip' => 'required|numeric',
        ]);

        if ($validator->errors()->count() > 0) {
            return response()->json(
                [
                    'error' => $validator->errors()->all(),
                    'error_length' => $validator->errors()->count()
                ]
            );
        }

        $user = Auth::user();
        $profile = User::find($user->id);
        $profile->email_verified_at = Carbon::now()->toDateTimeString();
        $user->update($request->data);
        Session::flash('success', 'User has been updated successfully!');
        return response()->json(
            [
                'action' => 'success',
                'error_length' => 0
            ]
        );
    }

    /**
     * About page
     *
     */
    public function about()
    {
        return view('front.about');
    }

    /**
     * Q and A page
     *
     */
    public function qa()
    {
        return view('front.q-a');
    }

    /**
     * Domain Info
     *
     */
    public function domainInfo($domain)
    {
        $domain = Domain::where('domain', $domain)->firstOrFail();
        $category = Category::where('id', $domain->category)->firstOrfail();
        $registrar = Registrar::where('id', $domain->registrar_id)->first();

        $no1   = rand(1, 5);
        $no2   = rand(1, 5);
        $total = $no1 + $no2;

        $domain->domain_age = Domain::computeAge($domain->reg_date, 0);

        return view('front.domain-info')
            ->with('domain', $domain)
            ->with('no1', $no1)
            ->with('no2', $no2)
            ->with('total', $total)
            ->with('registrar', $registrar)
            ->with('category', $category);
    }

    /**
     * Display the TOS Page
     * @method GET /tos
     * @return Renderable
     */

    public function tos()
    {
        return view('front.tos');
    }

    /**
     * Display the Privacy Policy Page
     * @method GET /privacy-policy
     * @return Renderable
     */

    public function privacy()
    {
        return view('front.privacy-policy');
    }

    /**
     * Display the Cookie Policy Page
     * @method GET /cookie-policy
     * @return Renderable
     */

    public function cookie()
    {
        return view('front.cookie-policy');
    }

    /**
     * Display the Cookie Eula Page
     * @method GET /eula
     * @return Renderable
     */

    public function eula()
    {
        return view('front.eula');
    }

    /**
     * Display the Cookie Disclaimer Page
     * @method GET /disclaimer
     * @return Renderable
     */

    public function disclaimer()
    {
        return view('front.disclaimer');
    }

    /**
     * Display the Cookie Disclaimer Page
     * @method GET /ccpa-do-not-sell
     * @return Renderable
     */

    public function ccpa()
    {
        return view('front.ccpa-do-not-sell');
    }
}
