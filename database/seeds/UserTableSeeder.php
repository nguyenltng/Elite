<?php

use Faker\Provider\Uuid;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \App\User::create([
            'name'=>'nguyen ',
            'email'=>'nguyenltng@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('nguyen')
        ]);
    }
}
