<?php

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$banners = 
    		[
                ['model' => 3425, 'banner' => '5d415fea4bebb_f-add-8.jpg'],
        	];
        DB::table('banners')->insert($banners);
    }
}
