<?php

namespace Modules\Promote\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PromoteDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        \DB::table('promote__promotes')->insert([
            [
                'price_amount' => 100,
                'number_of_date_expired' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], 
            [
                'price_amount' => 500,
                'number_of_date_expired' => 7,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], 
            [
                'price_amount' => 1500,
                'number_of_date_expired' => 30,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], 
        ]);
    }
}
