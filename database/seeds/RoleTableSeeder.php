<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Spatie\Permission\Models\Role::create(['display_name' => 'admin', 'name' => 'admin']);
        Spatie\Permission\Models\Role::create(['display_name' => 'Developer', 'name' => 'developer']);
        Spatie\Permission\Models\Role::create(['display_name' => 'User', 'name' => 'user']);

        App\User::where('id', 1)->first()->assignRole('admin');
        App\User::where('id', 2)->first()->assignRole('user');
        App\User::where('id', 3)->first()->assignRole('developer');
        App\User::where('id', 4)->first()->assignRole('user');
        App\User::where('id', 5)->first()->assignRole('developer');
    }
}
