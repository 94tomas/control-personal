<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $add = new User;
        $add->name = 'Administrador';
        $add->email = 'admin@dev.com';
        $add->password = bcrypt('asdfasdf');
        $add->save();
    }
}
