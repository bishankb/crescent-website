<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	User::create(
            [
                'name'           => 'Admin',
                'slug'           => str_slug('Admin'),
                'email'          => 'admin@admin.com',
                'password'       => bcrypt('secret'),
                'remember_token' => str_random(10),
                'role_id'        => 1, 
                'active'         => true,
            ]
        );
        
        User::create(
            [
                'name'           => 'Bishad Man Gubhaju',
                'slug'           => str_slug('Bishad Man Gubhaju'),
                'email'          => 'bishad@bishad.com',
                'password'       => bcrypt('secret'),
                'remember_token' => str_random(10),
                'role_id'        => 3,
                'active'         => true
            ]
        );

        User::create(
            [
                'name'           => 'Manoj Kumar Agrahari',
                'slug'           => str_slug('Manoj Kumar Agrahari'),
                'email'          => 'manoj@manoj.com',
                'password'       => bcrypt('secret'),
                'remember_token' => str_random(10),
                'role_id'        => 2,
                'active'         => true
            ]
        );

        User::create(
            [
                'name'           => 'Sunil Shreshta',
                'slug'           => str_slug('Sunil Shrestha'),
                'email'          => 'sunil@sunil.com',
                'password'       => bcrypt('secret'),
                'remember_token' => str_random(10),
                'role_id'        => 3,
                'active'         => true
            ]
        );

        User::create(
            [
                'name'           => 'Bishank Badgami',
                'slug'           => str_slug('Bishank Badgami'),
                'email'          => 'bishank@bishank.com',
                'password'       => bcrypt('secret'),
                'remember_token' => str_random(10),
                'role_id'        => 2,
                'active'         => true
            ]
        );
    }
}
