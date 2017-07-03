<?php

use Illuminate\Database\Seeder;

class ProductItemRelatedTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_item_related')->insert(array(
        	array('product_item_id' => 1, 'product_related_id' => 2),
            array('product_item_id' => 1, 'product_related_id' => 3),
        ));
    }
}
