<?php

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
        $uuid = Str::uuid()->toString();
        DB::table('users')->insert([
            [
                'id'=>$uuid,
            'name'=>'nguyen ',
            'email'=>'nguyenltng@gmail.com',
            'password' => Hash::make('nguyen') ],
        ]);
    }
}
