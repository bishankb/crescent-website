<?php

use Illuminate\Database\Seeder;
use App\UserProfile;

class UserProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserProfile::create(
            [
                'user_id'       => 2,
                'position'      => 'Civil Engineer',
                'phone1'        => '9806543559',
                'address'       => 'Mohariya Tole',
                'city'          => 'Pokhara',
                'user_image_id' => 8
            ]
        );

        UserProfile::create(
            [
                'user_id'       => 3,
                'position'      => 'Computer Engineer',
                'phone1'        => '9846467125',
                'address'       => 'Naya Baneshwor',
                'city'          => 'Kathmandu',
                'user_image_id' => 9
            ]
        );

        UserProfile::create(
            [
                'user_id'       => 4,
                'position'      => 'Civil Engineer',
                'phone1'        => '9806500070',
                'address'       => 'Mohariya Tole',
                'city'          => 'Pokhara',
                'user_image_id' => 8
            ]
        );

        UserProfile::create(
            [
                'user_id'       => 5,
                'position'      => 'Computer Engineer',
                'phone1'        => '9846728580',
                'address'       => 'Dhumbarahi',
                'city'          => 'Kathmandu',
                'user_image_id' => 9
            ]
        );
    }
}
