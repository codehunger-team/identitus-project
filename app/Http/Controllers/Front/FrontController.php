<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Domain;
use App\Models\Registrar;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Admin\DocusignController;
use Exception;
use Yajra\DataTables\Facades\DataTables;
use App\Services\WhoisService;
use Illuminate\Support\Facades\Auth;

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
            $autoSearch = "<script>$(#sbAjaxSearch).trigger('click');</script>";
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
        $dataTableSorting = $request->order[0];
        $domains = Domain::with('contract')->where('domain_status', 'AVAILABLE')
            ->when(isset($dataTableSorting) && $dataTableSorting['column'] == '2', function ($query) use ($dataTableSorting) {
                $query->orderBy('pricing', $dataTableSorting['dir']);
            })
            ->when(isset($filters['keyword']) && $filters['keyword'] != null, function ($query) use ($filters) {
                if ($filters['keyword_placement'] == 'contains') {
                    $query->where('domain', 'like', '%' . $filters['keyword'] . '%');
                }
                if ($filters['keyword_placement'] == 'starts_with') {
                    $query->where('domain', 'like', $filters['keyword'] . '%');
                }
                if ($filters['keyword_placement'] == 'ends_with') {
                    $query->whereRaw('SUBSTRING_INDEX(domain, ".", 1) like "%' . $filters['keyword'] . '"');
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
                $query->whereRaw('LENGTH(SUBSTRING_INDEX(domain, ".", 1)) <= ' . $filters['char_to']);
            })
            ->when(isset($filters['monthly_price_from']) && $filters['monthly_price_from'] != null && isset($filters['monthly_price_to']) && $filters['monthly_price_to'] != null, function ($query) use ($filters) {
                $query->WhereHas('contract', function ($query) use ($filters) {
                    $query->whereBetween('period_payment', [$filters['monthly_price_from'], $filters['monthly_price_to']]);
                });
            });
        return DataTables::of($domains)
            ->addIndexColumn()
            ->addColumn('pricing', function ($query) {
                return '<a href="' . route('ajax.add-to-cart.buy', $query->domain) . '>$' . $query->pricing . '</a>';
            })
            ->editColumn('contract.period_payment', function ($query) {
                return '<a href="' . route('review.terms', $query->domain) . '>$' . $query->contract->period_payment . '</a>';
            })
            ->editColumn('domain', function ($query) {
                return '<a href="' . route('domain.details', $query->domain) . '>' . $query->domain . '</a>';
            })
            ->addColumn('options', function ($query) {
                $action = '<div class="dropdown"> <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="buy" data-bs-toggle="dropdown" aria-expanded="false"> Get </a> <ul class="dropdown-menu" aria-labelledby="buy">';
                if (isset($query->contract->period_payment)) {
                    $action .= '<li><a href="' . route('review.terms', $query->domain) . '" class="dropdown-item">Lease Now</a></li>';
                };
                $action .=  '<li><a href="' . route('ajax.add-to-cart.buy', $query->domain) . '" class="dropdown-item">Buy Now</a></li>';
                return $action . '</ul> </div>';
            })
            ->rawColumns(['options', 'monthly_lease', 'domain', 'pricing', 'contract.period_payment'])
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
        $whois = (new WhoisService())->domainWhois($domain->domain);
        $category = Category::where('id', $domain->category)->first();
        $registrar = Registrar::where('id', $domain->registrar_id)->first();
        if (!isset($category)) {
            $category = 'Not Found';
        }
        $no1   = rand(1, 5);
        $no2   = rand(1, 5);
        $total = $no1 + $no2;

        $domain->domain_age = Domain::computeAge($domain->reg_date, 0);

        return view('front.domain-info')
            ->with('domain', $domain)
            ->with('whois', $whois)
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

    /**
     * This function is used to get domain search typeahead
     * @method GET /domain-typeahead
     * @param Request $request
     * @return JSON
     */

    public function domainSearchTypeahead(Request $request)
    {
        try {
            $request->validate(['keyword' => 'required']);
            $domains = Domain::where('domain_status', 'AVAILABLE')
                ->where('domain', 'like', '%' . $request->keyword . '%')->take(10)->get();
            return response()->json(['success' => true, 'data' => $domains, 'message' => 'Domain Data Fetched Successfully']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
}
