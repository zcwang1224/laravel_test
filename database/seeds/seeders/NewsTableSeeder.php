<?php

use Illuminate\Database\Seeder;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('news')->insert(array(
        		array(
						'content'         => 'news content test_1',
						'seo_title'       => 'news seo title test_1',
						'seo_description' => 'news seo description test_1',
						'seo_keyword'     => 'news seo keyword test_1'
					)
        	));
    }
}
