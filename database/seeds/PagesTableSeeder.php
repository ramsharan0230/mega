<?php

use App\Models\Page;
use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Page::truncate();
        $page = [
            ['title' => 'About Us', 'slug' => 'about-us', 'publish' => '1'],
        ];
        Page::insert($page);
    }
}
