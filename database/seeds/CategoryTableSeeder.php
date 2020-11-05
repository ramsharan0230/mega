<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();
        $datas = [
            ['title' => 'Platinum Exhibitor', 'slug' => str_slug('Platinum Exhibitor'), 'publish' => 1,],
            ['title' => 'Gold Exhibitor', 'slug' => str_slug('Gold Exhibitor'), 'publish' => 1,],
            ['title' => 'Silver Exhibitor', 'slug' => str_slug('Silver Exhibitor'), 'publish' => 1,],
            ['title' => 'Presenter', 'slug' => str_slug('Presenter'), 'publish' => 1,],
            ['title' => 'In Association With', 'slug' => str_slug('In Association With'), 'publish' => 1,],
        ];
        Category::insert($datas);
    }
}
