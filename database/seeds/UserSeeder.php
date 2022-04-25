<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
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
        $role_super = Role::where('name', 'superadmin')->first();
        $role_admin = Role::where('name', 'admin')->first();

        $faker = Faker::create();

        $add = new User;
        $add->name = $faker->firstName();
        $add->last_name = $faker->lastName();
        $add->username = 'admin';
        $add->email = 'admin@dev.com';
        $add->direction = $faker->streetAddress();
        $add->phone = $faker->e164PhoneNumber();
        $add->ci = $faker->randomNumber(7);
        $add->birthday = $faker->date($format = 'Y-m-d', $max = 'now');
        $add->status = 1;
        $add->password = bcrypt('asdfasdf');
        $add->save();
        $add->roles()->attach($role_admin);

        $add = new User;
        $add->name = $faker->firstName();
        $add->last_name = $faker->lastName();
        $add->username = 'superadmin';
        $add->email = 'superadmin@dev.com';
        $add->direction = $faker->streetAddress();
        $add->phone = $faker->e164PhoneNumber();
        $add->ci = $faker->randomNumber(7);
        $add->birthday = $faker->date($format = 'Y-m-d', $max = 'now');
        $add->status = 1;
        $add->password = bcrypt('asdfasdf');
        $add->save();
        $add->roles()->attach($role_super);
    }
}
