<?php

namespace App\Services\EyeVariable;

class ImagingMachineFactory
{
     public static function makeImagingService(string $service,$file,$modified) : ImagingMachineService
    {
        switch ($service)
        {
            case 'pentacam' : return new PentacamService($file,$modified);
            default : return new PentacamService($file,$modified);
        }
    }
}
