<?php

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class FeaturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $features = 
    		[
    			['name' => 'New', 'created_at' => Carbon::now()],
	        	['name' => 'Hot', 'created_at' => Carbon::now()],
        	];
        DB::table('features')->insert($features);
    }
}
