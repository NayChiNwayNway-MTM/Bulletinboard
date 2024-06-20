<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class PostListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $now = Carbon::now();
        DB::table('post_lists')->insert([
            [
                'title'=>'Title01',
                'description'=>'Description01',
                'status'=>1,
                'created_user_id'=>1,
                'updated_user_id'=>1,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),

            ],
            [
                'title'=>'Title02',
                'description'=>'Description02',
                'status'=>1,
                'created_user_id'=>2,
                'updated_user_id'=>2,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),

            ],
            [
                'title'=>'Title03',
                'description'=>'Description03',
                'status'=>1,
                'created_user_id'=>2,
                'updated_user_id'=>2,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),

            ],
            [
                'title'=>'Title04',
                'description'=>'Description04',
                'status'=>1,
                'created_user_id'=>3,
                'updated_user_id'=>3,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),

            ],
            [
                'title'=>'Title05',
                'description'=>'Description05',
                'status'=>1,
                'created_user_id'=>3,
                'updated_user_id'=>3,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),

            ],
            [
                'title'=>'Title06',
                'description'=>'Description06',
                'status'=>1,
                'created_user_id'=>1,
                'updated_user_id'=>1,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),

            ],
            [
                'title'=>'Title07',
                'description'=>'Description07',
                'status'=>1,
                'created_user_id'=>3,
                'updated_user_id'=>3,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),

            ],


        ]);
    }
}
