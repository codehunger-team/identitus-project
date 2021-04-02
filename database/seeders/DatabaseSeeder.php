<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        // $this->call(CategorySeeder::class);
        // $this->call(RegistrarSeeder::class);
        $this->call(OptionSeeder::class);
        // \App\Models\User::factory(10)->create();

        // Use it via tinker
        // User::Create([
        //     'name' => 'admin',
        //     'email' => 'admin@identitius.com',
        //     'password' => bcrypt('admin@1sdf234sdf'),
        //     'admin' => 1,
        //     'email_verified_at' => now(),
        // ]);
    }
}
