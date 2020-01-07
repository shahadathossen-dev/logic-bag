<?php

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class SlidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$sliders = 
    		[
                ['model' => '3425', 'image' => '5d415f86d466e_slider_3.jpg', 'created_at' => Carbon::now()],
        	];
        DB::table('sliders')->insert($sliders);
    }
}
