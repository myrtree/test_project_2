<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'user',
            'description' => 'Пользователь'
        ]);

        DB::table('roles')->insert([
            'name' => 'owner',
            'description' => 'Владелец'
        ]);

        DB::table('roles')->insert([
            'name' => 'admin',
            'description' => 'Администратор'
        ]);
    }
}
