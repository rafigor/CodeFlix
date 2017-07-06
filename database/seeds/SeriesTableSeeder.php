<?php

use CodeFlix\Models\Serie;
use CodeFlix\Repositories\SerieRepository;
use Illuminate\Database\Eloquent\Collection;
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
        /** @var Collection $series */
        $series = factory(Serie::class, 5)->create();
        $repository = app(SerieRepository::class);
        $colletionThumbs = $this->getThumbs();
        $series->each(function($serie) use($repository, $colletionThumbs){
            $repository->uploadThumb($serie->id, $colletionThumbs->random());
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
}
