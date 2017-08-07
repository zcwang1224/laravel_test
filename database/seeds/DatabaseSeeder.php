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
        $this->call(MemberTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(PermissionTableSeeder::class);

        $this->call(UserHasRolesTableSeeder::class);
        $this->call(SystemTableSeeder::class);
        // $this->call(StandTableSeeder::class);
        // $this->call(StandItemTableSeeder::class);        
    }
}
