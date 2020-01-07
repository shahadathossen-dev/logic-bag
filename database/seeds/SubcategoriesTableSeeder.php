<?php

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class SubcategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$subcategories = 
    		[
    			['category_id' => 1, 'title' => 'Wallet', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
		        ['category_id' => 1, 'title' => 'Laptop Bag', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
		        ['category_id' => 1, 'title' => 'Messenger Bag', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			    ['category_id' => 1, 'title' => 'Happer', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
		        ['category_id' => 1, 'title' => 'Vanity Bag', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
		        ['category_id' => 1, 'title' => 'Ladies Purse', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

		        ['category_id' => 2, 'title' => 'Wallet', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
		        ['category_id' => 2, 'title' => 'Laptop Bag', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
		        ['category_id' => 2, 'title' => 'Messenger Bag', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			    ['category_id' => 2, 'title' => 'Happer', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
		        ['category_id' => 2, 'title' => 'Vanity Bag', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
		        ['category_id' => 2, 'title' => 'Ladies Purse', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

		        ['category_id' => 3, 'title' => 'Wallet', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
		        ['category_id' => 3, 'title' => 'Laptop Bag', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
		        ['category_id' => 3, 'title' => 'Messenger Bag', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			    ['category_id' => 3, 'title' => 'Happer', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
		        ['category_id' => 3, 'title' => 'Vanity Bag', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
		        ['category_id' => 3, 'title' => 'Ladies Purse', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

		        ['category_id' => 4, 'title' => 'Laptop Bag', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
		        ['category_id' => 4, 'title' => 'Messenger Bag', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
			    ['category_id' => 4, 'title' => 'Happer', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
		        ['category_id' => 4, 'title' => 'Vanity Bag', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        	];
        DB::table('subcategories')->insert($subcategories);
    }
}
