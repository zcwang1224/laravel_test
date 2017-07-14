<?php

use Illuminate\Database\Seeder;

class MemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('member')->insert(array(
        		array(
						'content'         => 'member content test_1',
						'seo_title'       => 'member seo title test_1',
						'seo_description' => 'member seo description test_1',
						'seo_keyword'     => 'member seo keyword test_1'
					)
        	));
    }
}
