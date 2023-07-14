<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
   /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
        	'dashboards',
        	'users',
        	'blogs',
        	'products',
        	'services',
            'features',
            'roles'
        ];

        foreach ($permissions as $key => $permission) {
        	Artisan::call('crescent:auth:permission', ['name' => $permission]);
        }

    }
}
