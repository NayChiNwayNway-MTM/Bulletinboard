<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
                    'name'=>"Hla Hla",
                    'email'=>'hla@gmail.com',
                    'password'=>'123456',
                    'profile'=>'image.jpg',
                    'type'=>'0',
                    'phone'=>'912784615',
                    'address'=>'magway',
                    'dob'=>'12.3.2000',
                    'created_user_id'=>1,
                    'updated_user_id'=>1,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                ],
                [
                    'name'=>"Kyaw Kyaw",
                    'email'=>'kyaw@gmail.com',
                    'password'=>'123456',
                    'profile'=>'image.jpg',
                    'type'=>'0',
                    'phone'=>'912784615',
                    'address'=>'magway',
                    'dob'=>'12.3.2000',
                    'created_user_id'=>1,
                    'updated_user_id'=>1,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                ],
                [
                    'name'=>"Su Su",
                    'email'=>'susu@gmail.com',
                    'password'=>'123456',
                    'profile'=>'image.jpg',
                    'type'=>'0',
                    'phone'=>'912784615',
                    'address'=>'magway',
                    'dob'=>'12.3.2000',
                    'created_user_id'=>2,
                    'updated_user_id'=>2,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                ],
                [
                    'name'=>"Kaung Kaung",
                    'email'=>'kaung@gmail.com',
                    'password'=>'123456',
                    'profile'=>'image.jpg',
                    'type'=>'0',
                    'phone'=>'912784615',
                    'address'=>'magway',
                    'dob'=>'12.3.2000',
                    'created_user_id'=>2,
                    'updated_user_id'=>2,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                ],
                [
                    'name'=>"Naung Naung",
                    'email'=>'naung@gmail.com',
                    'password'=>'123456',
                    'profile'=>'image.jpg',
                    'type'=>'0',
                    'phone'=>'912784615',
                    'address'=>'magway',
                    'dob'=>'12.3.2000',
                    'created_user_id'=>2,
                    'updated_user_id'=>2,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                ],
                [
                    'name'=>"Tun Tun",
                    'email'=>'tt@gmail.com',
                    'password'=>'123456',
                    'profile'=>'image.jpg',
                    'type'=>'0',
                    'phone'=>'912784615',
                    'address'=>'magway',
                    'dob'=>'12.3.2000',
                    'created_user_id'=>2,
                    'updated_user_id'=>2,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                ],



             ]);
    }
}
