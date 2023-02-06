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
                'period_type' => 'Daily',
            ],
            '1' => [
                'period_type' => 'Weekly',
            ],
            '2' => [
                'period_type' => 'Monthly',
            ],
            '3' => [
                'period_type' => 'Quarterly',
            ],
            '4' => [
                'period_type' => 'Yearly',
            ],
        ];

        foreach ($datas as $key => $data) {
            PeriodType::create([
                'period_type' => $data['period_type'],
            ]);
        }
       
    }
}
