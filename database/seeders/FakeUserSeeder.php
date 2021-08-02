<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;


class FakeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 5; $i++) {
            $user = [
                'name' => $faker->name,
                'email' => $faker->email,
                'company' => $faker->company,                 
                'phone' => rand(1111111111, 9999999999),
                'country' => $faker->country,
                'state' => $faker->state,
                'city' => $faker->city,
                'street_1' => $faker->streetName,
                'street_2' => $faker->streetName,
                'zip' => $faker->postcode,
                'password' => bcrypt('12345678'),
                'email_verified_at' => now(),
                'admin' => 0,
            ];

            User::create($user);
        }
    }
}
