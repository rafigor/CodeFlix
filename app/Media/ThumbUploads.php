<?php
/**
 * Created by PhpStorm.
 * User: Rafael
 * Date: 26/06/2017
 * Time: 21:23
 */

namespace CodeFlix\Media;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Imagine\Image\Box;

trait ThumbUploads
{
    public function uploadThumb($id, UploadedFile $file){
        $model = $this->find($id);
        $name = $this->upload($model, $file, 'thumb');
        if($name){
            $this->deleteThumbsOld($model);
            $model->thumb = $name;
            $this->makeThumbSmall($model);
            $model->save();
        }
        return $model;
    }

    protected function makeThumbSmall($model){
        $storage = $model->getStorage();
        $thumbFile = $model->thumb_path;
        $format = \Image::format($thumbFile);
        $thumbnailSmall = \Image::open($thumbFile)->thumbnail(new Box(64, 36));
        $storage->put($model->thumb_small_relative, $thumbnailSmall->get($format));
    }

    public function deleteThumbsOld($model){
        $storage = $model->getStorage();
        if($storage->exists($model->thumb_relative) && $model->thumb != $model->thumb_default){
            $storage->delete([$model->thumb_relative, $model->thumb_small_relative]);
        }
    }

}