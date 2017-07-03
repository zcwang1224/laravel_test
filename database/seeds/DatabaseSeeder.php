<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(NewsTableSeeder::class);
        $this->call(NewsCategoryTableSeeder::class);
        $this->call(NewsItemTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(ProductCategoryTableSeeder::class);
        $this->call(ProductItemTableSeeder::class);
        $this->call(ProductItemRelatedTableSeeder::class);
    }
}