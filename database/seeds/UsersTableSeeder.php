<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role  = Role::where('name', 'admin')->first();

        $user = new User();
        $user->name = 'admin';
        $user->email = 'admin@test.test';
        $user->password = password_hash(env('ADMIN_PASSWORD'), PASSWORD_BCRYPT);
        $user->active = true;
        $user->save();

        $user->roles()->attach($role);
    }
}
