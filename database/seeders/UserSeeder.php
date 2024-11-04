<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::where('slug', '=', 'super-admin')->first();
        $employee = Employee::where('nik', '=', '000000000000000016')->first();

        DB::table('users')->insert([
            [
                'id' => '9d623586-9d62-4509-8138-411da151b424',
                'username' => 'superadmin',
                'password' => bcrypt('password'),
                'role_id' => $role->id,
                'employee_id' => $employee->id
            ],
        ]);
    }
}
