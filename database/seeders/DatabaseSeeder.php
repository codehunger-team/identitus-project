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
        $this->call(CategorySeeder::class);
        $this->call(RegistrarSeeder::class);
        $this->call(OptionSeeder::class);
        $this->call(OptionExpirationSeeder::class);
        $this->call(PeriodTypeSeeder::class);
        $this->call(GracePeriodSeeder::class);
        $this->call(NaviSeeder::class);
        // \App\Models\User::factory(10)->create();

        // Use it via tinker to create admin credential
        // User::Create([
        //     'name' => 'admin',
        //     'email' => 'admin@identitius.com',
        //     'password' => bcrypt('admin@1234'),
        //     'admin' => 1,
        //     'email_verified_at' => now(),
        // ]);
    }
}
