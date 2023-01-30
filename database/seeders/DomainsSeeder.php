<?php

namespace Database\Seeders;

use App\Models\Domain;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DomainsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tlds = ['.com', '.net', '.org', '.in', '.us', '.uk', '.co.in', '.co.uk'];
        $length = [3, 4, 5, 6, 7, 8, 9, 10];
        for ($i = 0; $i <= 20; $i++) {
            $domain = bin2hex(random_bytes($this->getRandomData($length)));
            $tld = $this->getRandomData($tlds);
            $domainsData = [
                'domain' => $domain . $tld,
                'tags' => 'tag1,tag2',
                'category' => '1',
                'description' => '<p>HEllo&nbsp;HEllo&nbsp;HEllo&nbsp;HEllo&nbsp;HEllo&nbsp;HEllo&nbsp;HEllo&nbsp;</p>',
                'user_id' => 1,
                'registrar_id' => 1,
                'pricing' => rand(100, 5000),
                'reg_date' => rand(1999, 2023) . '-' . sprintf('%02d', rand(00, 12)) . '-' . sprintf('%02d', rand(00, 28)),
                'short_description' => 'HEllo  HEllo HEllo HEllo HEllo HEllo',
                'domain_logo' => 'default-logo.jpg',
                'domain_status' => 'AVAILABLE',
                'discount' => '0',
            ];
            Domain::create($domainsData);
        }
    }

    /**
     * Return Random Data from the provided array
     * @param Array $array
     * @return Int $index
     */

    public function getRandomData($array)
    {
        $random = array_rand($array, 3);
        return $array[$random[0]];
    }
}
