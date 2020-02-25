<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name'      => 'Автор неизвестен',
                'email'     => 'author_unknown@gmail.com',
                'password'  => bcrypt(Str::random(16))
            ],
            [
                'name'      => 'Автор',
                'email'     => 'author167@gmail.com',
                'password'  => bcrypt('123456')
            ]
        ];
        DB::table('users')->insert($data);
    }
}
