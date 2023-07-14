<?php

use Illuminate\Database\Seeder;
use App\Feature;

class FeatureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Feature::create(
            [
                'title'        => 'Expert Technicians',
                'slug'         => str_slug('Expert Technicians'),
                'feature_icon' => '<span class="lnr lnr-home"></span>',
                'description'  => 'Usage of the Internet is becoming more common due to rapid advancement of technology and power.',
                'created_by'   => 1,
                'updated_by'   => 1,
            ]
        );

        Feature::create(
            [
                'title'        => 'Professional Service',
                'slug'         => str_slug('Professional Service'),
                'feature_icon' => '<span class="lnr lnr-license"></span>',
                'description'  => 'Usage of the Internet is becoming more common due to rapid advancement of technology and power.',
                'created_by'   => 1,
                'updated_by'   => 1,
            ]
        );

        Feature::create(
            [
                'title'        => 'Great Support',
                'slug'         => str_slug('Great Support'),
                'feature_icon' => '<span class="lnr lnr-phone"></span>',
                'description'  => 'Usage of the Internet is becoming more common due to rapid advancement of technology and power.',
                'created_by'   => 1,
                'updated_by'   => 1,
            ]
        );

        Feature::create(
            [
                'title'        => 'Technical Skills',
                'slug'         => str_slug('Technical Skills'),
                'feature_icon' => '<span class="lnr lnr-rocket"></span>',
                'description'  => 'Usage of the Internet is becoming more common due to rapid advancement of technology and power.',
                'created_by'   => 2,
                'updated_by'   => 2,
            ]
        );

        Feature::create(
            [
                'title'        => 'Highly Recomended',
                'slug'         => str_slug('Highly Recomended'),
                'feature_icon' => '<span class="lnr lnr-diamond"></span>',
                'description'  => 'Usage of the Internet is becoming more common due to rapid advancement of technology and power.',
                'created_by'   => 2,
                'updated_by'   => 2,
            ]
        );

        Feature::create(
            [
                'title'        => 'Positive Reviews',
                'slug'         => str_slug('Positive Reviews'),
                'feature_icon' => '<span class="lnr lnr-bubble"></span>',
                'description'  => 'Usage of the Internet is becoming more common due to rapid advancement of technology and power.',
                'created_by'   => 1,
                'updated_by'   => 1,
            ]
        );
    }
}
