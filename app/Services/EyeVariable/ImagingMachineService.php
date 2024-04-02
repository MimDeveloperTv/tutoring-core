<?php

namespace App\Services\EyeVariable;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

abstract class ImagingMachineService implements ImagingMachineServiceInterface
{
    protected string $type;
    protected string $uploadedFileUrl = '';
    public function __construct($file,$modified)
    {
        $this->traversalFile($file,$modified);
        $this->exertFile($this->uploadedFileUrl);
    }
    public function traversalFile($file,$modified): void
    {
        $originalName = $file->getClientOriginalName();
        $path = "$this->type/".Carbon::now()->format('Y-m-d')."/".$originalName;
        Storage::disk('local')->put($path,file_get_contents($file));
        $this->uploadedFileUrl = $path;
    }
}
