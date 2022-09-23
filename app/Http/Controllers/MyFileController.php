<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\MyFileRepoInterface;

class MyFileController extends Controller
{

    private MyFileRepoInterface $myfileRepo;

    public function __construct(MyFileRepoInterface $myfileRepo)
    {
        $this->myfileRepo = $myfileRepo;
    }

    public function upload(Request $request)
    {
        $this->validate($request,[
            "file" => "required|mimes:pdf|max:10000"
        ]);
        return $this->myfileRepo->upload($request->file('file'));
    }

    public function replace(Request $request)
    {
        $this->validate($request,[
            "file" => "required|mimes:pdf|max:10000",
            "id" => "required|exists:my_files,id"
        ]);
        return $this->myfileRepo->replace($request->file('file'),$request->get('id'));
    }

    public function delete(Request $request)
    {
        $this->validate($request,[
            "id" => "required|exists:my_files,id"
        ]);
        return $this->myfileRepo->delete($request->get('id'));
    }

    public function myFiles()
    {
        return $this->myfileRepo->myFiles();
    }

    public function tag(Request $request)
    {
        if($request->has('tags') && $request->has('id'))
            return $this->myfileRepo->tag($request->get('tags'),$request->get('id'));
    }
}
