<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait Upload_image
{
    public function uploadImage(Request $request , $folderName){
        $image = $request->file('personImage')->getClientOriginalName();
        $path = $request->file('personImage')->storeAs($folderName,$image,'uploadImg');
        return $path;
    }
}
