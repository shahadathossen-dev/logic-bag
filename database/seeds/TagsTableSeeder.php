<?php

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = 
    		[
    			['name' => 'Laptop Bag', 'created_at' => Carbon::now()],
	        	['name' => 'School Bag', 'created_at' => Carbon::now()],
	        	['name' => 'Ladies Purse', 'created_at' => Carbon::now()],
	        	['name' => 'Office Bag', 'created_at' => Carbon::now()],
	        	['name' => 'Messenger Bag', 'created_at' => Carbon::now()],
	        	['name' => 'Vanity Bag', 'created_at' => Carbon::now()]
        	];
        DB::table('tags')->insert($tags);
    }
}
