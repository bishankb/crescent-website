<?php

use Illuminate\Database\Seeder;
use App\Tag;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		Tag::create(
            [
            	'tag_for'    => 'blog',
                'title'      => 'Technology',
                'slug'       => str_slug('Technology'),
                'status'     => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ]
        );

        Tag::create(
            [
            	'tag_for'    => 'blog',
                'title'      => 'News',
                'slug'       => str_slug('News'),
                'status'     => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ]
        );

        Tag::create(
            [
            	'tag_for'    => 'blog',
                'title'      => 'Health',
                'slug'       => str_slug('Health'),
                'status'     => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ]
        );

        Tag::create(
            [
            	'tag_for'    => 'blog',
                'title'      => 'Science',
                'slug'       => str_slug('Science'),
                'status'     => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ]
        );
    }
}
