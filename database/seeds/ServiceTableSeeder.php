<?php

use Illuminate\Database\Seeder;
use App\Service;

class ServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::create(
            [
                'title'            => 'Web Application Development',
                'slug'             => str_slug('Web Application Development'),
                'description'      => 'We are using Laravel MVC framework for backend purpose of web application.',
                'service_image_id' => 5,
                'status'           => 1,
                'created_by'       => 1,
                'updated_by'       => 1,
            ]
        );

        Service::create(
            [
                'title'            => 'Mobile Application Development',
                'slug'             => str_slug('Mobile Application Development'),
                'description'      => 'We are buling responsive android app which are highly reliable and user friendly.',
                'service_image_id' => 6,
                'status'           => 1,
                'created_by'       => 2,
                'updated_by'       => 2,
            ]
        );

        Service::create(
            [
                'title'            => 'Api Integration',
                'slug'             => str_slug('Api Integration'),
                'description'      => 'We offer you well-versed with application program interfaces (APIs) to manage software applications.',
                'service_image_id' => 7,
                'status'           => 1,
                'created_by'       => 1,
                'updated_by'       => 1,
            ]
        );
    }
}
