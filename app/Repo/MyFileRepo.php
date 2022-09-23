<?php

namespace App\Repo;

use App\Interfaces\MyFileRepoInterface;
use App\Models\MyFile;
use Illuminate\Support\Facades\Storage;

class MyFileRepo implements MyFileRepoInterface
{
    public function myFiles()
    {
        return auth()->guard('users')->user()->myFiles ?? [];
    }

    public function upload($file)
    {
        $path = Storage::disk('public')->put('pdf', $file);
        return MyFile::create(['path' => $path, 'userId' => auth()->guard('users')->user()->id]);
    }

    public function replace($file, $fileId)
    {
        $myfile = Myfile::find($fileId);
        Storage::disk('public')->delete($myfile->id);
        $path = Storage::disk('public')->put('pdf', $file);
        return MyFile::where('id', $fileId)->update(['path' => $path]);
    }

    public function delete($fileId)
    {
        return MyFile::where('id', $fileId)->delete();
    }

    public function tag($tags,$fileId)
    {
        $tags = implode("|",$tags);
        return MyFile::where('id',$fileId)->update(['tags'=>$tags]);
    }
}
