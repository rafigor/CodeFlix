<?php
/**
 * Created by PhpStorm.
 * User: Rafael
 * Date: 10/07/2017
 * Time: 21:08
 */

namespace CodeFlix\Media;

use Illuminate\Http\UploadedFile;

trait Uploads
{
    public function upload($model, UploadedFile $file, $type){
        /** @var FilesystemAdapter $storage */
        $storage = $model->getStorage();

        $name = md5(time()."{$model->id}-{$file->getClientOriginalName()}").".{$file->getClientOriginalExtension()}";
        $result = $storage->putFileAs($model->{"{$type}_folder_storage"}, $file, $name);

        return $result ? $name : $result;
    }
}