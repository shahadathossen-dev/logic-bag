<?php

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->insert([
            'fname' => 'Shahadat',
            'lname' => 'Hossen',
            'email' => 'shobujlingdu@gmail.com',
            'username' => 'master',
            'role_id' => 1,
            'status_id' => 1,
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('asdfgh'),
            'created_at' => Carbon::now(),
        ]);

        $this->call([
            BannersTableSeeder::class,
            CategoriesTableSeeder::class,
	        FeaturesTableSeeder::class,
            OrderStatusesTableSeeder::class,
            PaymentMethodsTableSeeder::class,
            ProfilesTableSeeder::class,
            RolesTableSeeder::class,
            SlidersTableSeeder::class,
            StatusesTableSeeder::class,
            SubcategoriesTableSeeder::class,
	        TagsTableSeeder::class,
	    ]);
    }
}
