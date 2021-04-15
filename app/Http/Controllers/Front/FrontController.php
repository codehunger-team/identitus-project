<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Domain;
use App\Models\Category;

class FrontController extends Controller
{
    // all domains
    public function all_domains(Request $request) 
    {

        // get domain list from database
        $domain_list = Domain::WithContracts()->get();

        // append domain age to the list
        $domain_list->map( function($d) {
            $d->domain_age = Domain::computeAge( $d->reg_date, 0 );
        });


        // get tlds
        $tlds  = Domain::getAvailableExtensions();

        // get categories
        $categories = Category::orderBy( 'catname', 'ASC' )->get();

        // if keyword is set autofill keyword
        $autoKeyword = '';
        $autoSearch = '';

        if( $request->has( 'keyword' ) ) {
            $autoKeyword = trim(strip_tags( $request->get( 'keyword' )));
            $autoSearch = "<script>$(function() { $( '#ajax-search-form' ).trigger('submit'); });</script>";
        }

        // show view
        return view('front.domain-search.all-domains')
                    ->with('domains', $domain_list)
                    ->with('tlds', $tlds)
                    ->with('categories', $categories)
                    ->with( 'autoSearch', $autoSearch )
                    ->with( 'autoKeyword', $autoKeyword );

    }


    // ajax domain filtering
    public function domain_filtering( Request $r )
    {
        
        // filter sorting option
        $allowedSort = [ 'id.desc', 'pricing.asc', 'pricing.desc', 'domain.asc' ];

        //adult domain keyword collection
        $adultKeyword = ['4free','4u','accutane','actos','acyclovir','adderall','adipex','allegra','alprazolam','altace','ambien','amoxicillin','amoxil','amphetamine','anal','anime','antibiotic','arousal','atfreeforum','ativan','attorney','augmentin','azithromycin','babe','baccarat','bdsm','benadryl','biaxin','bitch','blackjack','blowjob','bondage','boob','booty','bowflex','bulabital','bupropion','butalbital','camry','car','carisoprodol','cartier','casino','celebrex','celexa','chick','cialis','cipro','citalopram','claritin','clonazepam','cock','codeine','codine','crestor','crotch','cruise','cruises','cum','cunt','cyclen','cyclobenzaprine','cymbalta','dada','diazepam','dick','didrex','diovan','directbookmarks','dodge','doxycycline','drugstores','edvttj','effexor','elavil','ephedra','ephedrine','erotica','escort','estate','facial','famvir','finland','fioricet','forex','freewebs','fuck','gambling','gay','glucophage','gucci','helsinki','hentai','holdem','honda','hoodia','horny','hummer','hydrochlorothiazide','hydrocodone','incest','indianapolis','jaguar','jewelry','lamictal','lasix','lesbian','lesbians','levaquin','levitra','lexapro','lexus','lipitor','loan','lopressor','lorazepam','masterbating','mazda','medication','meridia','metalica','mevacor','minolche','myfreedir','mysex','necklace','nexium','nicotine','nissan','norvasc','nude','orgasm','orgy','oxycodone','oxycontin','potassium','panties','panty','paxil','penis','percocet','pharmacy','phentermine','phpbb','plavix','poker','porn','potassium','pravachol','prednisone','prevacid','prilosec','propecia','protonix','prozac','pussy','rape','refinance','ringtones','ritalin','rolex','roulette','seroquel','sex','shemale','silveno','slot','soma','sphost','swinger','tadalafil','tadalis','tawnee','teen','testosterone','tetracycline','tissot','tit','toon','toyota','tramadol','trazodone','twinks','ultracet','ultram','valerian','valium','viagra','vicodin','vioxx','wellbutrin','wholesale','xanax','xenical','xxx','zanaflex','zenegra','zithromax','zocor','zoloft','zolus','zovirax','zyprexa'];

        if( !in_array( $r->sortby, $allowedSort ) )
            die( 'Invalid sort order' );

        $orderBy = explode( '.', $r->sortby );
        
        // get domains list ( apply order filter )
        //Laravel Shift recommended to chain multiple calls on a sort like this. Suggestion: i.e., in order to sort first by a, then b, then c, the correct clause would besortBy('c')->sortBy('b')->sortBy('a'). Per https://github.com/laravel/ideas/issues/11
        if( 'pricing.desc' == $r->sortby || 'pricing.asc' == $r->sortby ) {
            $domains = \App\Models\Domain::orderByRaw('(CASE WHEN (discount != 0 AND discount IS NOT NULL)
                                                 THEN 
                                                    discount 
                                                ELSE 
                                                    pricing 
                                                END) ' . $orderBy[ 1 ]);
        }else{
            $domains = \App\Models\Domain::orderBy( $orderBy[ 0 ], $orderBy[ 1 ] );
        }

        // apply category filter ( if required )
        if( $r->category > 0 )
            $domains->where( 'category', $r->category );

        // apply TLD filter ( if required )
        if( $r->extension != '' )
            $domains->where( 'domain', 'like', '%' . $r->extension );

        // apply keyword filter ( if required )
        if( $r->keyword != '' )
            $domains->where( 'domain', 'like', '%' . $r->keyword . '%' );

        if( $r->keyword_placement == 'starts_with' ) {
            $domains->where( 'domain', 'like', $r->keyword . '%' );   
        }

         // apply price filter ( if required )
         if( $r->price_to > 0 )
         {
             $domains->whereBetween( 'pricing',[$r->price_from,$r->price_to]);
                if (\Auth::check()) {
                 $d = $domains->WithContracts()->get();
             } 
         }  

        $d = $domains->get();

        if( $r->keyword_placement == 'ends_with' ) {
            $d =  \App\Models\Domain::getCharacterEndswith($r->keyword);
        }

        if(!isset($r->include_domains_with_numerals)) {
            $d =  \App\Models\Domain::getStringWithNoNumerals($r->keyword);
        } 

        if(!isset($r->include_domains_with_hyphens)) {
            $d =  \App\Models\Domain::getKeywordWithhyphens($r->keyword);
        }

        if(isset($r->domains_with_numerals_only)) {
            $d =  \App\Models\Domain::getKeywordWithNumerals($r->keyword);
        }
    
        // apply age filter ( if required )
        if( $r->age > 0 ) {
            $d = $d->reject(function ($domain) use ( $r ) {
                return \App\Models\Domain::computeAge($domain->reg_date, '') <= $r->age;
            });
        }

        // apply length filter ( if required )
        if( $r->char_to > 0 ) {
            $d = $d->filter(function ($domain) use ( $r ) {
                return \App\Models\Domain::getCharacterCount($domain->domain) <= $r->char_to;
            });
        }

        //check for adult domain keyword
        if(!isset($r->include_adult_domain) && in_array($r->keyword,$adultKeyword)) {
            $d = [];
        }
        if( !count( $d ) )
            return '<h3 class="text-center"><i class="fa fa-alert"></i> No domains matching the selected criteria</h3><br/><br/>';

        
        return view('front.components.domains-table')->with( 'domains', $d );

    }
}
