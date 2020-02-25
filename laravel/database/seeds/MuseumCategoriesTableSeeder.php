<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MuseumCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [];

        $cName = 'Без категории';

        $categories [] = [
            'title'     => $cName,
            'slug'      => Str::slug($cName),
            'parent_id' => 0
        ];

        for ($i = 1; $i <= 11; $i++) {
            $cName = 'Категория #' . $i;
            $parentId = ($i > 4) ? rand(1,4) : 1;


            $categories [] = [
                'title'     => $cName,
                'slug'      => Str::slug($cName),
                'parent_id' => $parentId
            ];
        }

        DB::table('museum_categories')->insert($categories);
    }
}
