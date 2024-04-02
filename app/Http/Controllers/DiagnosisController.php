<?php

namespace App\Http\Controllers;

use App\Models\Hard\Eye\EyeVariable;
use Illuminate\Http\Request;

class DiagnosisController extends Controller
{
    public function index(Request $request)
    {
        $eye_variable['os'] = EyeVariable::where('patient_id',$request->input('patient_id'))->where('eye_type','os')->first();
        $eye_variable['od'] = EyeVariable::where('patient_id',$request->input('patient_id'))->where('eye_type','od')->first();
        $data = [];
        foreach ($eye_variable as $key => $value)
        {
            $data[$key] = [
                'subjective_ref_sph' => $value->subjective_ref_sph > 0 ? "+".$value->subjective_ref_sph : $value->subjective_ref_sph,
                'subjective_ref_cyl' => $value->subjective_ref_cyl > 0 ? "+".$value->subjective_ref_cyl : $value->subjective_ref_cyl,
                'subjective_ref_axis' => $value->subjective_ref_axis,
                'k_reading_k1' => $value->K1_D,
                'k_reading_k1_rs' => (float) number_format((float)$value->K1_D ? (337.5/$value->K1_D) : null, 2, '.', ''),
                'k_reading_k2' => $value->K2_D,
                'k_reading_k2_rh' => (float)(number_format((float)$value->K2_D ? (337.5/$value->K2_D) : null, 2, '.', '')),
                'axis_flat' => $value->Axis_flat,
                'astig_topo' => $value->astig_topo,
                'tickness' => $value->pachy_min
            ];
        }
        return response()->json($data);
    }
}
