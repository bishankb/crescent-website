<?php

use Illuminate\Database\Seeder;
use App\ContactUs;

class ContactUsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	ContactUs::create(
            [
				'phone1'      => '9806543559',
				'phone2'      => '9846467125', 
				'phone3'      => '9806500070', 
				'phone4'      => '9846728580',
				'google_plus' => 'https://plus.google.com/103354720739296844275',
                'address'     => 'Mohariya Tole, Pokhara - 1, Nepal',
                'email'       => 'nepal.crescent@gmail.com',
            ]
        );
    }
}
