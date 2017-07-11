<?php

use Illuminate\Database\Seeder;

class StandItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('stand_item')->insert(array(
								        		array(
														'stand_id'         => 1,
														'stand_item_name'       => '紅色',
													),
								        		array(
														'stand_id'         => 1,
														'stand_item_name'       => '藍色',
													),
								        		array(
														'stand_id'         => 1,
														'stand_item_name'       => '綠色',
													),
								        		array(
														'stand_id'         => 2,
														'stand_item_name'       => 'S',
													),  
								        		array(
														'stand_id'         => 2,
														'stand_item_name'       => 'M',
													),  																										      		
								        	)
								        );
    }
}
