<?php

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
         $this->call(UsersTableSeeder::class);
         $this->call(MuseumCategoriesTableSeeder::class);
         factory(\App\Models\MuseumPost::class, 100)->create();
    }
}
