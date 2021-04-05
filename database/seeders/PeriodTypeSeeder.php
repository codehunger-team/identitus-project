<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PeriodType;

class PeriodTypeSeeder extends Seeder
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
                'period_type' => 'Day',
            ],
            '1' => [
                'period_type' => 'Week',
            ],
            '2' => [
                'period_type' => 'Month',
            ],
            '3' => [
                'period_type' => 'Quarter',
            ],
            '4' => [
                'period_type' => 'Year',
            ],
        ];

        foreach ($datas as $key => $data) {
            PeriodType::create([
                'period_type' => $data['period_type'],
            ]);
        }
       
    }
}
