<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create(
            [
                'title'            => 'eBUSINESS',
                'slug'             => str_slug('eBUSINESS'),
                'description'      => 'This plan is specially designed for different types of businesses with Full featured website plus Mobile Apps with International Standard.',
                'features'         => '<ul>
										<li>Beautiful design with Push Notification</li>
										<li>&nbsp;Mobile Payment Capability</li>
										<li>Feedback System from Clients</li>
										<li>Marketing Strategies</li>
										<li>Annual analysis report</li>
									</ul>',
                'product_image_id' => 10,
                'status'           => 1,
                'created_by'       => 3,
                'updated_by'       => 3,
            ]
        );

        Product::create(
            [
                'title'            => 'eSHOP',
                'slug'             => str_slug('eSHOP'),
                'description'      => 'This plan is specially designed for Online Shopping Stores with Full featured website plus Mobile Apps with International Standard.',
                'features'         => '<ul>
											<li>&nbsp;Beautiful design with Push Notification</li>
											<li>&nbsp;eCommerce enabled with Online Payment System</li>
											<li>&nbsp;Near by showrooms all over Nepal with Map</li>
											<li>&nbsp;Showcasing products with all important features and price</li>
											<li>New Products arrival notifications</li>
										</ul>',
                'product_image_id' => 11,
                'status'           => 1,
                'created_by'       => 2,
                'updated_by'       => 2,
            ]
        );

        Product::create(
            [
                'title'            => 'eELECTRONICS',
                'slug'             => str_slug('eELECTRONICS'),
                'description'      => 'This plan is specially designed for Electronic Stores with Full featured website plus Mobile Apps with International Standard.',
                'features'         => '<ul>
										<li>Beautiful design with Push Notification</li>
										<li>&nbsp;Mobile Payment Capability</li>
										<li>Feedback System from Clients</li>
										<li>Marketing Strategies</li>
										<li>Annual analysis report</li>
									</ul>',
                'product_image_id' => 12,
                'status'           => 1,
                'created_by'       => 4,
                'updated_by'       => 4,
            ]
        ); 
    }
}
