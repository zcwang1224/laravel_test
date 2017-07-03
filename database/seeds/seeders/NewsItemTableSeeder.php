<?php

use Illuminate\Database\Seeder;

class NewsItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('news_item')->insert(array(
        	array(
                'news_category_id' => 1,
                'name'             => 'news item test1', 
                'content'          => 'content test1',
                'seo_title'        => 'seo title test1',
                'seo_description'  => 'seo description test1',
                'seo_keyword'      => 'seo keyword test1',
                'status'           => 1,
            ),
            array(
                'news_category_id' => 1,                
                'name'             => 'news item test2', 
                'content'          => 'content test2',
                'seo_title'        => 'seo title test2',
                'seo_description'  => 'seo description test2',
                'seo_keyword'      => 'seo keyword test2',
                'status'           => 0,
            ),            
            array(
                'news_category_id' => 1,                
                'name'             => 'news item test3', 
                'content'          => 'content test3',
                'seo_title'        => 'seo title test3',
                'seo_description'  => 'seo description test3',
                'seo_keyword'      => 'seo keyword test3',
                'status'           => 1,
            )           
        ));
    }
}
