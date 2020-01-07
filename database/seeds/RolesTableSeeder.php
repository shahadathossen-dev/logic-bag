<?php

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$roles = 
    		[
    			['name' => 'Master', 'created_at' => Carbon::now()],
	        	['name' => 'Admin', 'created_at' => Carbon::now()],
	        	['name' => 'Editor', 'created_at' => Carbon::now()],
	        	['name' => 'CSR', 'created_at' => Carbon::now()],
	        	['name' => 'Order Executive', 'created_at' => Carbon::now()]
        	];
        DB::table('roles')->insert($roles);
    }
}
