<?php

namespace App\Services;

use App\Models\Service;
use PHPUnit\Framework\Attributes\After;

class PlanningService
{
   public function services()
   {
       $services = Service::all();
   }
}
