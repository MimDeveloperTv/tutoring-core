<?php

namespace App\Http\Controllers\Planning;

use App\Http\Controllers\Controller;
use App\Services\PlanningConditionService;
use App\Traits\ResponseTemplate;
use Illuminate\Http\Request;

class PlanningController extends Controller
{
    use ResponseTemplate;
    public function getPlanningErrors(Request $request)
    {
        $this->setData((new PlanningConditionService($request->patient_id))->getErrorMessages());
        return $this->response();
    }
}
