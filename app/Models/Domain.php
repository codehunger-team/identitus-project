<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{

    // fillable
    protected $fillable = ['domain', 'pricing', 'registrar_id', 'reg_date', 'exp_date',
        'domain_age', 'description', 'short_description', 'discount',
        'category', 'user_id', 'tags'];

    // get available extensions
    public static function getAvailableExtensions()
    {

        // get all domains from DB
        $all_domains = self::select('domain')->get();

        // setup extensions array
        $extensions = [];

        // loop
        foreach ($all_domains as $domain) {
            array_push($extensions, pathinfo($domain->domain, PATHINFO_EXTENSION));
        }

        return array_unique($extensions, SORT_STRING);

    }

    // get character count
    public static function getCharacterCount($domainName)
    {

        return strlen(strtok($domainName, '.'));

    }

    /**
     * Check for the particular keyword ends with.
     *
     * @return array
     */
    public static function getCharacterEndswith($keyword)
    {

        $userId = null;

        if (Auth::check()) {
            $userId = Auth::user()->id;
        }

        $domainfilters = self::where('domain', 'like', '%' . $keyword . '%')->where('domain_status', 'AVAILABLE')->get();
        $domainID = [];

        foreach ($domainfilters as $key => $domainfilter) {
            $removeDelimiter = strtoupper(strtok($domainfilter->domain, '.'));
            $keywordUpperCase = strtoupper($keyword);
            $lastWordComparison = substr_compare($removeDelimiter, $keywordUpperCase, -strlen($keywordUpperCase)) === 0;
            if ($lastWordComparison) {
                $domainID[] = $domainfilter->id;
            }
        }

        $data = self::whereIn('id', $domainID)->get();

        return $data;
    }

    /**
     * CHeck whether keyword contains number or not
     *
     * @return array
     */
    public static function getStringWithNoNumerals($keyword)
    {

        $userId = null;

        if (Auth::check()) {
            $userId = Auth::user()->id;
        }

        $domainfilters = self::where('domain', 'like', '%' . $keyword . '%')->where('domain_status', 'AVAILABLE')->get();

        $domainID = [];

        foreach ($domainfilters as $key => $domainfilter) {
            $removeDelimiter = strtoupper(strtok($domainfilter->domain, '.'));
            $isNumeral = preg_match('/\\d/', $removeDelimiter);
            if (!$isNumeral) {
                $domainID[] = $domainfilter->id;
            }
        }
        $data = self::whereIn('id', $domainID)->get();

        return $data;
    }

    /**
     * Split string and numeral.
     *
     * @return array
     */
    public static function getKeywordWithNumerals($keyword)
    {

        $userId = NULL;

        if (Auth::check()) {
            $userId = Auth::user()->id;
        }

        $domainID = [];

        $seperateNumberString = preg_replace("/[^0-9]{1,4}/", '', $keyword);

        $domainfilters = self::where('domain', 'like', '%' . $seperateNumberString . '%')->where('domain_status', 'AVAILABLE')->get();

        foreach ($domainfilters as $key => $domainfilter) {

            $removeDelimiter = strtoupper(strtok($domainfilter->domain, '.'));
            if (ctype_digit($removeDelimiter)) {
                $domainID[] = $domainfilter->id;
            }
        }

        $data = self::whereIn('id', $domainID)->get();

        return $data;
    }

    /**
     * Get Domain With IDN.
     *
     * @return array
     */
    public static function getKeywordWithIDN($keyword)
    {
        $userId = NULL;

        if (Auth::check()) {
            $userId = Auth::user()->id;
        }

        $domainID = [];

        $domainfilters = self::where('domain', 'like', '%' . $keyword . '%')->where('domain_status', 'AVAILABLE')->get();

        foreach ($domainfilters as $key => $domainfilter) {

            $removeDelimiter = strtoupper(strtok($domainfilter->domain, '.'));
            if (preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $removeDelimiter)) {

                $domainID[] = $domainfilter->id;

            }
        }

        $data = self::whereIn('id', $domainID)->get();

        return $data;
    }

    /**
     * Keyword with hyphens.
     *
     * @return array
     */
    public static function getKeywordWithhyphens($keyword)
    {   
        $userId = NULL;

        if (Auth::check()) {
            $userId = Auth::user()->id;
        }

        $domainID = [];

        $domainfilters = self::where('domain', 'like', '%' . $keyword . '%')->where('domain_status', 'AVAILABLE')->get();

        foreach ($domainfilters as $key => $domainfilter) {
            $removeDelimiter = strtoupper(strtok($domainfilter->domain, '.'));

            if (!substr_count($removeDelimiter, '-')) {
                $domainID[] = $domainfilter->id;
            }
        }

        $data = self::whereIn('id', $domainID)->get();

        return $data;
    }

    // compute age
    public static function computeAge($reg_date, $exp_date)
    {

        // parse dates
        $reg_date = \Carbon\Carbon::parse($reg_date);
        $exp_date = \Carbon\Carbon::parse(date('Y-m-d'));

        // years difference
        $years_diff = $exp_date->diffInYears($reg_date);

        // return age difference
        return $years_diff;

    }

    // use "domain" for the model injection into routes
    public function getRouteKeyName()
    {
        return 'domain';
    }

    // has one category
    public function industry()
    {
        return $this->hasOne(\App\Categories::class, 'catID', 'category');
    }

    // filter contract on domain_id
    public function scopeWithContracts($query)
    {
        $userId = null;

        if (Auth::check()) {
            $userId = Auth::user()->id;
        }
        
        $query->leftJoin('contracts', function ($join) {
            $join->on('domains.id', '=', 'contracts.domain_id');
        })->select('domains.pricing', 'domains.domain_status', 'domains.domain', 'domains.discount', 'contracts.period_payment')
            ->where('domain_status', 'AVAILABLE')
            // ->where('user_id', '!=', $userId)
            ->orderby('id', 'DESC');
    }

    //Count of domain listed by lessor
    public static function domainCount($userId)
    {
        return self::where('user_id', $userId)->count();
    }

    public function contract()
    {
        return $this->hasOne('App\Models\Contract');
    }

}
