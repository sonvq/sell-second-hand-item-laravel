<?php

namespace Modules\Country\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class CountryDatabaseSeeder extends Seeder
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
        DB::table('country__countries')->insert([
            [
                'name' => 'Myanmar',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], 
            [
                'name' => 'Singapore',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'China',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Vietnam',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Thailand',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]]
        );
    }
}
