<?php

use Illuminate\Database\Seeder;

class StandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('stand')->insert(array(
        		array(
						'product_item_id'         => 1,
						'stand_name'       => '顏色一',
					),
        		array(
						'product_item_id'         => 1,
						'stand_name'       => '尺寸一',
					),
        		array(
						'product_item_id'         => 2,
						'stand_name'       => '顏色二',
					),
        		array(
						'product_item_id'         => 2,
						'stand_name'       => '尺寸二',
					),        		
        	));
    }
}
