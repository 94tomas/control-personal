<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_super = Role::where('name', 'super')->first();
        $role_admin = Role::where('name', 'admin')->first();

        $add = new User;
        $add->name = 'Administrador';
        $add->username = 'admin';
        $add->email = 'admin@dev.com';
        $add->password = bcrypt('asdfasdf');
        $add->save();
        $add->roles()->attach($role_admin);

        $add = new User;
        $add->name = 'Super Administrador';
        $add->username = 'super';
        $add->email = 'super@dev.com';
        $add->password = bcrypt('asdfasdf');
        $add->save();
        $add->roles()->attach($role_super);
    }
}
