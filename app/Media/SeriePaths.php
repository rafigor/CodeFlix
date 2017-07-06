<?php
/**
 * Created by PhpStorm.
 * User: Rafael
 * Date: 05/06/2017
 * Time: 22:09
 */

namespace CodeFlix\Media;


trait SeriePaths
{
    use ThumbPaths;

    public function getThumbFolderStorageAttribute(){
        return "series/{$this->id}";
    }

    public function getThumbAssetAttribute(){
        return route('admin.series.thumb_asset',['serie' => $this->id]);
    }

    public function getThumbSmallAssetAttribute(){
        return route('admin.series.thumb_small_asset',['serie' => $this->id]);
    }

    public function getThumbDefaultAttribute(){
        return env('SERIE_NO_THUMB');
    }
}