<?php

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$methods = 
    		[
    			['mode' => 'Paypal','description' => 'Pay full cash after you have received the product in hand and ensured that the delivered product is appropriate.'],
		        ['mode' => 'Cash On Delivery','description' => 'Pay full cash after you have received the product in hand and ensured that the delivered product is appropriate.'],
		        ['mode' => 'Direct Bank Transfer','description' => 'Pay full cash after you have received the product in hand and ensured that the delivered product is appropriate.'],
		        ['mode' => 'Credit Card','description' => 'Pay full cash after you have received the product in hand and ensured that the delivered product is appropriate.'],
        	];
        DB::table('payment_methods')->insert($methods);
    }
}
