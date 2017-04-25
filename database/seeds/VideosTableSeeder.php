<?php

use CodeFlix\Models\Category;
use CodeFlix\Models\Serie;
use CodeFlix\Models\Video;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class VideosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var Collection $series */
        $series = Serie::all();
        $categories = Category::all();
        factory(Video::class, 100)->create()->each(function($video) use($series, $categories){
            $video->categories()->attach($categories->random(4)->pluck('id'));
            $num = rand(1,3);
            if($num%2==0){
                $serie = $series->random();
                $video->serie_id = $serie->id;
                $video->serie()->associate($serie);
                $video->save();
            }
        });
    }
}
