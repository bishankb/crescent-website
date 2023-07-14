<?php

use Illuminate\Database\Seeder;
use App\Media;

class MediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		Media::create(
            [
                'filename'          => 'UlKePiizAVdfMoJnx1ohuMpbsSIU1SOOVrOPCsSD.jpeg',
				'original_filename' => 'Blog1.jpg',
				'extension'         => 'jpg',
				'mime'              => 'image/jpeg', 
				'type'              => 'image', 
				'file_size'         => '211855', 
            ]
        );

        Media::create(
            [
                'filename'          => 's6f9cw5S3DfQcbUgzBaMRSCT2N1BcwOqB3HnrHDJ.png',
				'original_filename' => 'Blog.png',
				'extension'         => 'png',
				'mime'              => 'image/png', 
				'type'              => 'image', 
				'file_size'         => '74839', 
            ]
        );

        Media::create(
            [
                'filename'          => 'ZF4jkHYTeDb7LCEFZoPoTp8vJfREffjWA1zFZ6yG.jpeg',
				'original_filename' => 'Blog3.jpg',
				'extension'         => 'jpg',
				'mime'              => 'image/jpeg', 
				'type'              => 'image', 
				'file_size'         => '184938', 
            ]
        );

        Media::create(
            [
                'filename'          => '1Hd6owf5jxDK0g626VaKqxrlAHx0pSbuLsxURj3w.png',
				'original_filename' => 'Blog4.png',
				'extension'         => 'png',
				'mime'              => 'image/png', 
				'type'              => 'image', 
				'file_size'         => '108041', 
            ]
        );

        Media::create(
            [
                'filename'          => 'zJ9nt24i43nCo4Y2OMqgvUyNsCvLbasYG4JGMd6u.png',
                'original_filename' => 'Service1.png',
                'extension'         => 'png',
                'mime'              => 'image/png', 
                'type'              => 'image', 
                'file_size'         => '8023', 
            ]
        );

        Media::create(
            [
                'filename'          => '6aR4EO3KgQbMi8K1VzRzNpbHd49KFawdbiG27Q7T.png',
                'original_filename' => 'Service2.png',
                'extension'         => 'png',
                'mime'              => 'image/png', 
                'type'              => 'image', 
                'file_size'         => '9065', 
            ]
        );

        Media::create(
            [
                'filename'          => 'dHDaWoBBv2zBHoIxbQnf6YdU0OnOP9qznyRuR6zw.png',
                'original_filename' => 'Service3.png',
                'extension'         => 'png',
                'mime'              => 'image/png', 
                'type'              => 'image', 
                'file_size'         => '10801', 
            ]
        );

        Media::create(
            [
                'filename'          => 'raNJb5R252EhJO7U6HMLNP7RRcOtdRNZv60uuRAO.jpeg',
                'original_filename' => 'User1.jpeg',
                'extension'         => 'jpg',
                'mime'              => 'image/jpeg', 
                'type'              => 'image', 
                'file_size'         => '10352', 
            ]
        );

        Media::create(
            [
                'filename'          => 'twYK6envlAwwI6eb2FNmTdWSig8T9CQQZtGhBvDC.jpeg',
                'original_filename' => 'Uswer2.jpeg',
                'extension'         => 'jpg',
                'mime'              => 'image/jpeg', 
                'type'              => 'image', 
                'file_size'         => '21351', 
            ]
        );

        Media::create(
            [
                'filename'          => 'R9hJM6TP75JFAmPozxcXdriQ9pt9Y82jgwEwjlM4.png',
                'original_filename' => 'Product1.png',
                'extension'         => 'png',
                'mime'              => 'image/png', 
                'type'              => 'image', 
                'file_size'         => '111589', 
            ]
        );

        Media::create(
            [
                'filename'          => '5yRvNbgSzXeWZx6ZVfhZrDUDZz5Ee1NYdj1dqD60.png',
                'original_filename' => 'Product2.png',
                'extension'         => 'png',
                'mime'              => 'image/png', 
                'type'              => 'image', 
                'file_size'         => '269321', 
            ]
        );

        Media::create(
            [
                'filename'          => 'NRZxhiN5xgagZDnz1DobW58tyzuP9s9flyyICm0c.png',
                'original_filename' => 'Product3.png',
                'extension'         => 'png',
                'mime'              => 'image/png', 
                'type'              => 'image', 
                'file_size'         => '311607', 
            ]
        );
    }
}
