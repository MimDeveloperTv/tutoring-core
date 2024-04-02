<?php

namespace App\Services\EyeVariable;

interface ImagingMachineServiceInterface
{
    public function traversalFile($file,$modified) : void;
    public function exertFile($url) : void;
}
