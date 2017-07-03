<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(array(
        	array('name' => 'zcwang', 'email' => 'zcwang1224@gmail.com', 'password' => bcrypt('0000')),
            array('name' => 'test'  , 'email' => 'test@gmail.com'      , 'password' => bcrypt('0000'))
        ));
    }
}
