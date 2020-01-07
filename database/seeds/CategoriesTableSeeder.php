<?php

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$categories = 
    		[
    			['title' => 'Leather', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
	        	['title' => 'Jute', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
	        	['title' => 'Rexene', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
	        	['title' => 'Polyester', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        	];
        DB::table('categories')->insert($categories);
    }
}
