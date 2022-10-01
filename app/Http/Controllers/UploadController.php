<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api');
    }


    public function uploadProfilePicture(Request $request){

        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg|max:2048'
        ]);

        $image_path = $request->file('image')->store('image', 'public');

        $Image_data = Image::create([
            'image' => $image_path,
        ]);

        return response()->json([
            'status'=>'success',
            'message'=>'Image uploaded Successfully!',
            'image_path'=>$image_path,
        ]);

    }
}
