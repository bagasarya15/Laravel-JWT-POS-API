<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run() : void
   {
        DB::table('employees')->insert([
            [
                'id' => '9d623586-9d62-4509-8138-411da151b424',
                'nik' => '000000000000000016',
                'firstname' => 'Bagas',
                'lastname' => 'Arya',
                'email' => 'bagas@gmail.com',
                'phone_number'=> '081285711519',
                'last_education' => 'Bachelor',
            ],
        ]);
   }
}
