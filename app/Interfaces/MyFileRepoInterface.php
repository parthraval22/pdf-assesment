<?php

namespace App\Interfaces;

interface MyFileRepoInterface
{
    public function myFiles();
    public function upload($file);
    public function replace($file, $fileId);
    public function delete($fileId);
    public function tag($tags,$fileId);
}
