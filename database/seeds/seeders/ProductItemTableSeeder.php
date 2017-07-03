<?php

use Illuminate\Database\Seeder;

class ProductItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_item')->insert(array(
        		array(
                        'product_category_id' => 1, 
                        'name'                => 'product item test_1', 
                        'description1'        => 'description test_1', 
                        'content1'            => 'content test 1',
                        'seo_title'           => 'seo_title test 1',
                        'seo_description'     => 'seo_description test 1',
                        'seo_keyword'         => 'seo_keyword test 1',
                    ),
				array(
                        'product_category_id' => 2, 
                        'name'                => 'product item test_2', 
                        'description1'        => 'description test_2', 
                        'content1'            => 'content test 2',
                        'seo_title'           => 'seo_title test 2',
                        'seo_description'     => 'seo_description test 2',
                        'seo_keyword'         => 'seo_keyword test 2',                         
                    ),
				array(
                        'product_category_id' => 3, 
                        'name'                => 'product item test_3', 
                        'description1'        => 'description test_3', 
                        'content1'            => 'content test 3',
                        'seo_title'           => 'seo_title test 3',
                        'seo_description'     => 'seo_description test 3',
                        'seo_keyword'         => 'seo_keyword test 3',                         
                    ),
				array(
                        'product_category_id' => 4, 
                        'name'                => 'product item test_4', 
                        'description1'        => 'description test_4', 
                        'content1'            => 'content test 4',
                        'seo_title'           => 'seo_title test 4',
                        'seo_description'     => 'seo_description test 4',
                        'seo_keyword'         => 'seo_keyword test 4',                          
                    ),
				array(
                        'product_category_id' => 5, 
                        'name'                => 'product item test_5', 
                        'description1'        => 'description test_5', 
                        'content1'            => 'content test 5',
                        'seo_title'           => 'seo_title test 5',
                        'seo_description'     => 'seo_description test 5',
                        'seo_keyword'         => 'seo_keyword test 5',                           
                    ),
				array(
                        'product_category_id' => 6, 
                        'name'                => 'product item test_6', 
                        'description1'        => 'description test_6', 
                        'content1'            => 'content test 6',
                        'seo_title'           => 'seo_title test 6',
                        'seo_description'     => 'seo_description test 6',
                        'seo_keyword'         => 'seo_keyword test 6',                         
                    ) 				 				     		
        	));
    }
}
