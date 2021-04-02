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
            'currency_symbol' => '$',
            'currency_code' => 'USD',
        ];
        
        foreach($options as $option) {
            Option::create([
                'name' =>  $options['currency_symbol'],
                'value' => $options['currency_code'],
             ]);
        }
       
    }
}
