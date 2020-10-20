<?php

use App\Model\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'nguyen ',
            'email' => 'nguyenltng@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('nguyen')
        ]);
    }
}
