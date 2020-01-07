<?php

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class TradeMarksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$trades = 
    		[
                ['type' => 'logo', 'content' => 'logicbag-logo.png'],
                ['type' => 'facebook', 'content' => 'https://www.facebook.com/Logic-Bag-249378482065781'],
                ['type' => 'email', 'content' => 'info@logitechcomputers.com'],
    			['type' => 'phone', 'content' => '+880-1847-277630'],
        	];
        DB::table('trade_marks')->insert($trades);
    }
}
