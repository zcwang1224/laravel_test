<?php

use Illuminate\Database\Seeder;

class ProductCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_category')->insert(array(
        		array(
                        'parent'          => 1, 
                        'name'            => 'product category test_1', 
                        'description'     => 'description test_1', 
                        'content'         => 'content test 1',
                        'seo_title'       => 'seo_title test 1',
                        'seo_description' => 'seo_description test 1',
                        'seo_keyword'     => 'seo_keyword test 1',
                    ),
				array(
                        'parent'          => 2, 
                        'name'            => 'product category test_2', 
                        'description'     => 'description test_2', 
                        'content'         => 'content test 2',
                        'seo_title'       => 'seo_title test 2',
                        'seo_description' => 'seo_description test 2',
                        'seo_keyword'     => 'seo_keyword test 2',                        
                    ),
				array(
                        'parent'          => 3, 
                        'name'            => 'product category test_3', 
                        'description'     => 'description test_3', 
                        'content'         => 'content test 3',
                        'seo_title'       => 'seo_title test 3',
                        'seo_description' => 'seo_description test 3',
                        'seo_keyword'     => 'seo_keyword test 3',                           
                        ),
				array(
                        'parent'          => 4, 
                        'name'            => 'product category test_4', 
                        'description'     => 'description test_4', 
                        'content'         => 'content test 4',
                        'seo_title'       => 'seo_title test 4',
                        'seo_description' => 'seo_description test 4',
                        'seo_keyword'     => 'seo_keyword test 4',                          
                    ),
				array(
                        'parent'          => 5, 
                        'name'            => 'product category test_5', 
                        'description'     => 'description test_5', 
                        'content'         => 'content test 5',
                        'seo_title'       => 'seo_title test 5',
                        'seo_description' => 'seo_description test 5',
                        'seo_keyword'     => 'seo_keyword test 5',                         
                    ),
				array(
                        'parent'          => 6, 
                        'name'            => 'product category test_6', 
                        'description'     => 'description test_6', 
                        'content'         => 'content test 6',
                        'seo_title'       => 'seo_title test 6',
                        'seo_description' => 'seo_description test 6',
                        'seo_keyword'     => 'seo_keyword test 6',                         
                ) 				 				     		
        	));
    }
}
