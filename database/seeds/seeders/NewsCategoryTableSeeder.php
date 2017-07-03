<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class NewsCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('news_category')->insert(array(
        	array(
                'name'            => 'news catagory test1', 
                'content'         => 'content test1',
                'seo_title'       => 'seo title test1',
                'seo_description' => 'seo description test1',
                'seo_keyword'     => 'seo keyword test1',
                'status'          => 1,
            ),
            array(
                'name'            => 'news catagory test2', 
                'content'         => 'content test2',
                'seo_title'       => 'seo title test2',
                'seo_description' => 'seo description test2',
                'seo_keyword'     => 'seo keyword test2',
                'status'          => 0,
            ),            
            array(
                'name'            => 'news catagory test3', 
                'content'         => 'content test3',
                'seo_title'       => 'seo title test3',
                'seo_description' => 'seo description test3',
                'seo_keyword'     => 'seo keyword test3',
                'status'          => 1,
            )           
        ));
    }
}
