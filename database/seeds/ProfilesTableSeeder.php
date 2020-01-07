<?php

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profiles')->insert([
            'user_id' => 1,
            'phone' => '01711085864',
            'created_at' => Carbon::now(),
        ]);
    }
}
