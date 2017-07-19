<?php
/**
 * Created by PhpStorm.
 * User: Rafael
 * Date: 05/06/2017
 * Time: 22:04
 */

namespace CodeFlix\Media;


use Illuminate\Filesystem\FilesystemAdapter;

trait VideoStorages
{
    /**
     * @return \Illuminate\Filesystem\FilesystemAdapter
     */
    public function getStorage(){
        return \Storage::disk($this->getDiskDriver());
    }

    protected function getDiskDriver(){
        return config('filesystems.default');
    }

    protected function getAbsolutePath(FilesystemAdapter $storage, $fileRelativePath){
        return $this->isLocalDriver()?
            $storage->getDriver()->getAdapter()->applyPathPrefix($fileRelativePath):
            $storage->url($fileRelativePath);
    }

    protected function isLocalDriver(){
        return config("filesystems.disks.{$this->getDiskDriver()}.driver")=='local';
    }
}