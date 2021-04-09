<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Navi;

class NaviSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $navis = [
            '0' => [
                'title' => '/Home',
                'url' => '/',
                'target' => '_self',
            ],
            '1' => [
                'title' => '/About',
                'url' => '/#about',
                'target' => '_self',
            ],
            '2' => [
                'title' => '/Domains',
                'url' => '/domains',
                'target' => '_self',
            ],
            '3' => [
                'title' => '/Checkout',
                'url' => '/checkout',
                'target' => '_self',
            ],
            '4' => [
                'title' => '/Contact',
                'url' => '/contact',
                'target' => '_self',
            ],
            '5' => [
                'title' => '/Q&A\'s',
                'url' => '/p-questions-and-answers',
                'target' => '_self',
            ],
        ];

        foreach($navis as $navi) {
            Navi::create([
                'title' => $navi['title'],
                'url' => $navi['url'],
                'target' => $navi['target'],
            ]);
        }
       
    }
}
