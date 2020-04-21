<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function download()
    {
        return response()->download(public_path('arnob.png'), 'Bangladesh Flag');
    }

    public function upload(Request $request)
    {
        $fileName = "User.jpg";
        $path = $request->file('photo')->move(public_path('/'), $fileName);
        $photoURL = url('/' . $fileName);
        return response()->json(['url' => $photoURL], 200);
    }
}
