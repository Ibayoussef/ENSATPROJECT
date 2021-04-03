<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students')->insert([
            'name' => "Houda Mzari",
            'email' => "houda@gmail.com",
            'codedapogee' => "PD19852",
            'cin' => "198526",
            'doc_id' => "Attestation Scholaire"
        ]);
    }
}
