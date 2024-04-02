<?php

namespace App\Http\Controllers\Surgery;

use App\Http\Controllers\Controller;
use App\Services\SurgeryCalculationService;
use App\Traits\ResponseTemplate;
use Illuminate\Http\Request;

class SurgeryController extends Controller
{
    use ResponseTemplate;
    public function getSurgeryFormData(Request $request)
    {
        $this->setData((new SurgeryCalculationService($request->patient_id,$request->eye_type,$request->surgery_calculation))->getSurgeryData());
        return $this->response();
    }
}
