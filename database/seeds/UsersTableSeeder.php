<?php

use App\Models\User;
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
        for ($x = 0; $x<20; $x++) {
            $user = new User;
            $user->name = Str::random(10);
            $user->email = Str::random(15).'@gmail.com';
            $user->password = bcrypt('password');
            $user->role_id = rand(1,2);
            $user->save();
            $user = null;
        } 
    }
}
