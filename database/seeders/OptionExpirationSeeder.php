<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OptionExpiration;

class OptionExpirationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            '0' => [
                'option_expiration' => '1 month prior to lease expiration',
            ],
            '1' => [
                'option_expiration' => '2 weeks prior to lease expiration',
            ],
            '2' => [
                'option_expiration' => '3 days prior to lease expiration',
            ],
            '3' => [
                'option_expiration' => '2 days prior to lease expiration',
            ],
            '4' => [
                'option_expiration' => '1 day prior to lease expiration',
            ],
            '5' => [
                'option_expiration' => 'simultaneous with lease expiration',
            ],
        ];

        foreach ($datas as $key => $data) {
            OptionExpiration::create(
                [
                    'option_expiration' => $data['option_expiration'],
                ]
            );
        }
    }
}
