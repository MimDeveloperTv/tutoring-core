<?php

namespace App\Http\Controllers\Imaging;

use App\Services\EyeVariable\ImagingMachineFactory;
use App\Services\EyeVariable\PentacamService;
use Illuminate\Http\Request;

class FileUploaderController
{
    public function store(Request $request)
    {
         $request->validate([
             'file' => 'required'
         ]);
         ImagingMachineFactory::makeImagingService('pentacam',$request->file('file'),$request->modified);
         return response()->json(['status' => 'success'],200);
    }
}
