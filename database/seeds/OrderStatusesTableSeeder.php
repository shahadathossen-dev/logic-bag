<?php

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class OrderStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$statuses = 
    		[
		        ['name' => 'Processing', 'created_at' => Carbon::now()],
                ['name' => 'On Hold', 'created_at' => Carbon::now()],
                ['name' => 'Cancelled', 'created_at' => Carbon::now()],
		        ['name' => 'Shipped', 'created_at' => Carbon::now()],
                ['name' => 'Delivered', 'created_at' => Carbon::now()],
		        ['name' => 'Closed', 'created_at' => Carbon::now()],
        	];
        DB::table('order_statuses')->insert($statuses);
    }
}
