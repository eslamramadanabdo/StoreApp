<?php

namespace Database\Seeders;

use Hash;
use Illuminate\Database\Seeder;
use  App\Models\User;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'         => 'IslamRamadan',
            'email'        => 'islam@gmail.com',
            'password'     => Hash::make('password'),
            'phone_number' => '01118405757'
        ]);

        DB::table('users')->insert(
            [
                'name'         => 'EslamRamadan',
                'email'        => 'eslam@gmail.com',
                'password'     => Hash::make('password'),
                'phone_number' => '01118405758'
            ]
        );
    }
}
