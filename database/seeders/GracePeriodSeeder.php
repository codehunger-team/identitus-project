<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GracePeriod;

class GracePeriodSeeder extends Seeder
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
                'grace_period' => '30',
            ],
            '1' => [
                'grace_period' => '15',
            ],
            '2' => [
                'grace_period' => '10',
            ],
            '3' => [
                'grace_period' => '5',
            ],
            '4' => [
                'grace_period' => '4',
            ],
            '5' => [
                'grace_period' => '3',
            ],
            '6' => [
                'grace_period' => '2',
            ],
            '7' => [
                'grace_period' => '1',
            ],
            '8' => [
                'grace_period' => '0',
            ],
        ];

        foreach ($datas as $key => $data) {
            GracePeriod::create(
                [
                    'grace_period' => $data['grace_period'],
                ]
            );
        }
    }
}
