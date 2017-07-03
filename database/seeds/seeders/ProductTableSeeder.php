<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product')->insert(array(
        		array(
						'content'         => 'product content test_1',
						'seo_title'       => 'product seo title test_1',
						'seo_description' => 'product seo description test_1',
						'seo_keyword'     => 'product seo keyword test_1'
					)
        	));
    }
}
