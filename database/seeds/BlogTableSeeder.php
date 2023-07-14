<?php

use Illuminate\Database\Seeder;
use App\Blog;

class BlogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $blog1 = Blog::create(
            [
                'title'          => 'At long last, Gmail starts converting addresses and contact info into links',
                'slug'           => str_slug('At long last, Gmail starts converting addresses and contact info into links'),
                'description'    => '<p>Gmail is packed with a lot of time-saving features, like Smart Replies for mobile users. So it&rsquo;s a bit surprising to realize that Gmail will only now start to automatically detect and convert addresses, phone numbers and contacts into links.</p>',
                'category_id'    => 1,
                'blog_image_id'  => 1,
                'status'         => 1,
                'created_by'     => 2,
                'updated_by'     => 2,
            ]
        );
        $blog1->tags()->attach([1, 2]);

        $blog2 = Blog::create(
            [
                'title'          => 'SAP is buying identity management firm Gigya for $350M',
                'slug'           => str_slug('SAP is buying identity management firm Gigya for $350M'),
                'description'    => '<p>SAP, the German enterprise software giant, today announced an acquisition to strengthen its hybris e-commerce division. It has acquired Gigya, a firm that helps online properties manage customer identities and profiles. Terms of the deal have not been disclosed officially, but our sources tell us it is for $350 million.</p>',
                'category_id'    => 2,
                'blog_image_id'  => 2,
                'status'         => 1,
                'created_by'     => 3,
                'updated_by'     => 3,
            ]
        );
        $blog2->tags()->attach([2, 3]);

        $blog3 = Blog::create(
            [
                'title'          => 'Beats Studio 3 bring premium noise canceling and battery life at a premium price',
                'slug'           => str_slug('Beats Studio 3 bring premium noise canceling and battery life at a 						premium price'),
                'description'    => '<p>Beats had a handful of different sounds on hand to test the Studio 3 ahead of launch. The demo was designed to showcase the range of the headphones’ new adaptive noise-canceling technology — but there’s only so much you can get from a demo in that kind of controlled environment. The closest the whole thing got to real-world unpredictability was a desktop fan pointed directly at the headphones to simulate the annoying static crunch of wind.</p>',
                'category_id'    => 3,
                'blog_image_id'  => 3,
                'status'         => 1,
                'created_by'     => 4,
                'updated_by'     => 4,
            ]
        );
        $blog3->tags()->attach([1, 3]);

        $blog4 = Blog::create(
            [
                'title'          => 'Brush up on Chinese modern art',
                'slug'           => str_slug('Brush up on Chinese modern art'),
                'description'    => '<p>For the last century, the Central Academy of Fine Arts (CAFA) in Beijing has been the preeminent school of art education in China. Some of the most renowned masters of Chinese modern art trained at this hallowed institution and many of their works are stored in the CAFA Art Museum.</p>',
                'category_id'    => 4,
                'blog_image_id'  => 4,
                'status'         => 1,
                'created_by'     => 2,
                'updated_by'     => 2,
            ]
        );
        $blog4->tags()->attach([2, 4]); 
    }
}
