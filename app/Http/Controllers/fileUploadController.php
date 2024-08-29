<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class fileUploadController extends Controller
{
    public function fileUpload (Request $req){

        $req->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $filePath = $req->file('file')->store('public/images');
        $fileName = basename($filePath);

        return view('uploadView', ['path' => $fileName]);
    }
}
