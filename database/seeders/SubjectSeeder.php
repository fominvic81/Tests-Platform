<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subjects')->insert(['name' => '...']);
        DB::table('subjects')->insert(['name' => 'Українська мова']);
        DB::table('subjects')->insert(['name' => 'Математика']);
        DB::table('subjects')->insert(['name' => 'Англійська']);
    }
}
