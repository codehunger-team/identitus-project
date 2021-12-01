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

    // ajax domain filtering
    public function domain_filtering(Request $r)
    {

        // filter sorting option
        $allowedSort = ['id.desc', 'pricing.asc', 'pricing.desc', 'domain.asc'];

        //adult domain keyword collection
        $adultKeyword = ['4free', '4u', 'accutane', 'actos', 'acyclovir', 'adderall', 'adipex', 'allegra', 'alprazolam', 'altace', 'ambien', 'amoxicillin', 'amoxil', 'amphetamine', 'anal', 'anime', 'antibiotic', 'arousal', 'atfreeforum', 'ativan', 'attorney', 'augmentin', 'azithromycin', 'babe', 'baccarat', 'bdsm', 'benadryl', 'biaxin', 'bitch', 'blackjack', 'blowjob', 'bondage', 'boob', 'booty', 'bowflex', 'bulabital', 'bupropion', 'butalbital', 'camry', 'car', 'carisoprodol', 'cartier', 'casino', 'celebrex', 'celexa', 'chick', 'cialis', 'cipro', 'citalopram', 'claritin', 'clonazepam', 'cock', 'codeine', 'codine', 'crestor', 'crotch', 'cruise', 'cruises', 'cum', 'cunt', 'cyclen', 'cyclobenzaprine', 'cymbalta', 'dada', 'diazepam', 'dick', 'didrex', 'diovan', 'directbookmarks', 'dodge', 'doxycycline', 'drugstores', 'edvttj', 'effexor', 'elavil', 'ephedra', 'ephedrine', 'erotica', 'escort', 'estate', 'facial', 'famvir', 'finland', 'fioricet', 'forex', 'freewebs', 'fuck', 'gambling', 'gay', 'glucophage', 'gucci', 'helsinki', 'hentai', 'holdem', 'honda', 'hoodia', 'horny', 'hummer', 'hydrochlorothiazide', 'hydrocodone', 'incest', 'indianapolis', 'jaguar', 'jewelry', 'lamictal', 'lasix', 'lesbian', 'lesbians', 'levaquin', 'levitra', 'lexapro', 'lexus', 'lipitor', 'loan', 'lopressor', 'lorazepam', 'masterbating', 'mazda', 'medication', 'meridia', 'metalica', 'mevacor', 'minolche', 'myfreedir', 'mysex', 'necklace', 'nexium', 'nicotine', 'nissan', 'norvasc', 'nude', 'orgasm', 'orgy', 'oxycodone', 'oxycontin', 'potassium', 'panties', 'panty', 'paxil', 'penis', 'percocet', 'pharmacy', 'phentermine', 'phpbb', 'plavix', 'poker', 'porn', 'potassium', 'pravachol', 'prednisone', 'prevacid', 'prilosec', 'propecia', 'protonix', 'prozac', 'pussy', 'rape', 'refinance', 'ringtones', 'ritalin', 'rolex', 'roulette', 'seroquel', 'sex', 'shemale', 'silveno', 'slot', 'soma', 'sphost', 'swinger', 'tadalafil', 'tadalis', 'tawnee', 'teen', 'testosterone', 'tetracycline', 'tissot', 'tit', 'toon', 'toyota', 'tramadol', 'trazodone', 'twinks', 'ultracet', 'ultram', 'valerian', 'valium', 'viagra', 'vicodin', 'vioxx', 'wellbutrin', 'wholesale', 'xanax', 'xenical', 'xxx', 'zanaflex', 'zenegra', 'zithromax', 'zocor', 'zoloft', 'zolus', 'zovirax', 'zyprexa'];

        if (!in_array($r->sortby, $allowedSort)) {
            die('Invalid sort order');
        }

        $orderBy = explode('.', $r->sortby);

        // get domains list ( apply order filter )
        //Laravel Shift recommended to chain multiple calls on a sort like this. Suggestion: i.e., in order to sort first by a, then b, then c, the correct clause would besortBy('c')->sortBy('b')->sortBy('a'). Per https://github.com/laravel/ideas/issues/11
        if ('pricing.desc' == $r->sortby || 'pricing.asc' == $r->sortby) {
            $domains = \App\Models\Domain::orderByRaw('(CASE WHEN (discount != 0 AND discount IS NOT NULL)
                                                 THEN
                                                    discount
                                                ELSE
                                                    pricing
                                                END) ' . $orderBy[1]);
        } else {
            $domains = \App\Models\Domain::orderBy($orderBy[0], $orderBy[1]);
        }

        // apply category filter ( if required )
        if ($r->category > 0) {
            $d = $domains->where('category', $r->category)->get();
        }

        // apply TLD filter ( if required )
        if ($r->extension != '') {
            $d = $domains->where('domain', 'like', '%' . $r->extension)->get();
        }

        // apply keyword filter ( if required )
        if ($r->keyword != '') {
            $d = $domains->where('domain', 'like', '%' . $r->keyword . '%')->get();
        } else {
            $d = $domains->get();
        }

        if ($r->keyword_placement == 'starts_with') {
            $d = $domains->where('domain', 'like', $r->keyword . '%')->get();
        }

        // apply price filter ( if required )
        if ($r->price_to > 0 && $r->price_to != '∞') {
            $d = $domains->whereBetween('pricing', [$r->price_from, $r->price_to])->get();
        }

        // apply monthly price filter ( if required )
        if ($r->monthly_price_to > 0 && $r->monthly_price_to != '∞') {
            $d = Domain::join('contracts', 'domain.id', '=', 'contracts.domain_id')
                ->whereBetween('pricing', [$r->monthly_price_from, $r->monthly_price_to])
                ->get();
        }

        if ($r->keyword_placement == 'ends_with') {
            $d = \App\Models\Domain::getCharacterEndswith($r->keyword);
        }


        // apply age filter ( if required )
        if ($r->age > 0) {
            $d = $d->reject(function ($domain) use ($r) {
                return \App\Models\Domain::computeAge($domain->reg_date, '') <= $r->age;
            });
        }

        // apply length filter ( if required )
        if ($r->char_to > 0) {
            $d = $d->filter(function ($domain) use ($r) {
                return \App\Models\Domain::getCharacterCount($domain->domain) <= $r->char_to;
            });
        }

        //check for adult domain keyword
        if (!isset($r->include_adult_domain) && in_array($r->keyword, $adultKeyword)) {
            $d = [];
        }
        if (!count($d)) {
            return '<h3 class="text-center"> No domains matching the selected criteria</h3><br/><br/>';
        }

        return view('front.components.domains-table')->with('domains', $d);
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
}
