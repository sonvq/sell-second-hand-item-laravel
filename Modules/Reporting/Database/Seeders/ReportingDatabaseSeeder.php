<?php

namespace Modules\Reporting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class ReportingDatabaseSeeder extends Seeder
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
        DB::table('reporting__reasons')->insert([
            [
                'name' => 'Inappropriate content',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], 
            [
                'name' => 'Cancel appointment after confirmation',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], 
            [
                'name' => 'Do not show up on appointment',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], 
        ]);
    }
}
