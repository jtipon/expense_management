<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Role; 
        $admin->name = 'administrator';
        $admin->description = 'super user';
        $admin->save();

        $user = new Role; 
        $user->name = 'user';
        $user->description = 'basic user';
        $user->save();
    }   
}
