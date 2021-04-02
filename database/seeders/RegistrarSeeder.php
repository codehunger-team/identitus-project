<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Registrar;

class RegistrarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $registrar = ['Network Solutions','GoDaddy','Namecheap'];

        foreach ($registrar as $registrar) {
            Registrar::create([
                'registrar'=> $registrar,
            ]);
        }
        
    }
}
