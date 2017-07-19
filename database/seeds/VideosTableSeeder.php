<?php

use CodeFlix\Models\Category;
use CodeFlix\Models\Serie;
use CodeFlix\Models\Video;
use CodeFlix\Repositories\VideoRepository;
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

        $repository = app(VideoRepository::class);
        $colletionThumbs = $this->getThumbs();
        $colletionFiles = $this->getFiles();

        factory(Video::class, 2)->create()->each(function($video) use(
            $series,
            $categories,
            $repository,
            $colletionThumbs,
            $colletionFiles
        ){
            $video->categories()->attach($categories->random(4)->pluck('id'));
            $repository->uploadThumb($video->id, $colletionThumbs->random());
            $repository->uploadFile($video->id, $colletionFiles->random());
            $num = rand(1,3);
            if($num%2==0){
                $serie = $series->random();
                $video->serie_id = $serie->id;
                $video->serie()->associate($serie);
                $video->save();
            }
        });
    }

    protected function getThumbs(){
        return new \Illuminate\Support\Collection([
            new \Illuminate\Http\UploadedFile(
                storage_path('app/files/faker/thumbs/photob-galinha-pintadinha-capa.png'),
                'photob-galinha-pintadinha-capa.png'
            ),
        ]);
    }

    protected function getFiles(){
        return new \Illuminate\Support\Collection([
            new \Illuminate\Http\UploadedFile(
                storage_path('app/files/faker/videos/VID-20161017-WA0057.mp4'),
                'VID-20161017-WA0057.mp4'
            ),
        ]);
    }
}
