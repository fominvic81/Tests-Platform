<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('grades')->insert(['name' => '1 клас']);
        DB::table('grades')->insert(['name' => '2 клас']);
        DB::table('grades')->insert(['name' => '3 клас']);
        DB::table('grades')->insert(['name' => '4 клас']);
        DB::table('grades')->insert(['name' => '5 клас']);
        DB::table('grades')->insert(['name' => '6 клас']);
        DB::table('grades')->insert(['name' => '7 клас']);
        DB::table('grades')->insert(['name' => '8 клас']);
        DB::table('grades')->insert(['name' => '9 клас']);
        DB::table('grades')->insert(['name' => '10 клас']);
        DB::table('grades')->insert(['name' => '11 клас']);
        DB::table('grades')->insert(['name' => '12 клас']);
        DB::table('grades')->insert(['name' => '1 курс']);
        DB::table('grades')->insert(['name' => '2 курс']);
        DB::table('grades')->insert(['name' => '3 курс']);
        DB::table('grades')->insert(['name' => '4 курс']);
    }
}
