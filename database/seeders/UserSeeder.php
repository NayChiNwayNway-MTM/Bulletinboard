<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $now = Carbon::now();
        DB::table('users')->insert(
            [
                [
                    'name'=>"Nay Chi",
                    'email'=>'naychi@gmail.com',
                    'password'=>Hash::make('123456'),
                    'type'=>'0',
                    'phone'=>'912784615',
                    'address'=>'magway',
                    'dob'=>'12.3.2000',
                    'created_user_id'=>1,
                    'updated_user_id'=>1,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                ]
                

             ]);
    }
}
