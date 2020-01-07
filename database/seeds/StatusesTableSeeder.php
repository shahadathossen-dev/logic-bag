<?php

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
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
    			['name' => 'Active','created_at' => Carbon::now()],
		        ['name' => 'Deactive','created_at' => Carbon::now()],
		        ['name' => 'Pending','created_at' => Carbon::now()],
		        ['name' => 'Approved','created_at' => Carbon::now()],
		        ['name' => 'OnHold','created_at' => Carbon::now()]
        	];
        DB::table('statuses')->insert($statuses);
    }
}
