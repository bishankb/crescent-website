<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(TagTableSeeder::class);
        $this->call(MediaTableSeeder::class);
        $this->call(UserProfileTableSeeder::class);
        $this->call(BlogTableSeeder::class);
        $this->call(FeatureTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(ServiceTableSeeder::class);
        $this->call(ContactUsTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
    }
}
