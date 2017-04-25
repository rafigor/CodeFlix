<?php

use CodeFlix\Models\Serie;
use Illuminate\Database\Seeder;

class SeriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Serie::class, 5)->create();
    }
}
