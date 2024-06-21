<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('posts')->insert([
            [
                'title'=>'Title01',
                'description'=>'Description01',
                'status'=>1,
                'created_user_id'=>1,
                'updated_user_id'=>1,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),

            ]

        ]);
    }
}
