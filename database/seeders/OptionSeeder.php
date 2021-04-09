<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Option;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $options = [
            '0' => [
                'name' => 'currency_symbol',
                'value' =>'$',
            ],
            '1' => [
                'name' => 'currency_code',
                'value' =>'USD',
            ],
            '3' => [
                'name' => 'site_title',
                'value' =>'Identitius',
            ],
            '4' => [
                'name' => 'admin_email',
                'value' =>'info@identitius.com',
            ],
            '5' => [
                'name' => 'navi_order',
                'value' =>'1,2,3,4,5',
            ],
            '6' => [
                'name' => 'seo_title',
                'value' =>'Identitius: easy domain name leasing.',
            ],
            '7' => [
                'name' => 'seo_desc',
                'value' =>'Don\'t sell domains, lease them instead. Identitius makes domain name leasing easy.',
            ],
            '8' => [
                'name' => 'seo_keys',
                'value' =>'identitius, lease domain, lease domain names, lease domains',
            ],
            '9' => [
                'name' => 'contact_email',
                'value' =>'info@identitius.com',
            ],
            '10' => [
                'name' => 'homepage_headline',
                'value' =>'Lease the perfect domain',
            ],
            '11' => [
                'name' => 'homepage_intro',
                'value' =>'while retaining the option to buy!',
            ],
            '12' => [
                'name' => 'enable_logos',
                'value' =>'No',
            ],
            '13' => [
                'name' => 'enable_shortdesc',
                'value' =>'No',
            ],
            '14' => [
                'name' => 'about_us',
                'value' =>'All the perfect domains are taken by speculators. Speculators wait for years for the big pay day, that often never comes. In the meantime, forth-tier domains are starting to get used, but don’t carry the “Park Avenue” credibility.Identitius bridges that gap. Find your identity today.',
            ],
            '15' => [
                'name' => 'phone_number',
                'value' =>'123 123 1234',
            ],
            '16' => [
                'name' => 'facebook_follow_us',
                'value' =>'http://facebook.com',
            ],
            '17' => [
                'name' => 'twitter_follow_us',
                'value' =>'https://twitter.com/identitius',
            ],
            '18' => [
                'name' => 'linkedin_follow_us',
                'value' =>'http://linkedIn.com',
            ],
            '19' => [
                'name' => 'phoneIcon',
                'value' =>'No',
            ],
            '20' => [
                'name' => 'fbIcon',
                'value' =>'No',
            ],
            '21' => [
                'name' => 'currency_symbol',
                'value' =>'$',
                'twIcon' => 'Yes',
            ],
            '22' => [
                'name' => 'linkedIcon',
                'value' =>'$',
            ],
            '23' => [
                'name' => 'financingEnable',
                'value' =>'No',
            ],
            '24' => [
                'name' => 'currency_symbol',
                'value' =>'$',
            ],
            '25' => [
                'name' => 'currency_code',
                'value' =>'USD',
            ],
            '26' => [
                'name' => 'paypalEnable',
                'value' =>'No',
            ],
            '27' => [
                'name' => 'stripeEnable',
                'value' =>'Yes',
            ],
            '26' => [
                'name' => 'escrowEnable',
                'value' =>'No',
            ],
            '26' => [
                'name' => 'paypalEnable',
                'value' =>'No',
            ],
            
        ];
        
        foreach($options as $option) {
            Option::create([
                'name' =>  $option['name'],
                'value' => $option['value'],
             ]);
        }
       
    }
}
