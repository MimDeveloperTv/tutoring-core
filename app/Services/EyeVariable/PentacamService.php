<?php

namespace App\Services\EyeVariable;

use App\Models\Hard\Eye\EyeVariable;
use App\Models\MedicalRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class PentacamService extends ImagingMachineService
{
    protected string  $type = 'pentacam';
    public function exertFile($url): void
    {
        $content = Storage::get($url);
        $lines = explode(PHP_EOL,$content);
        $keys = $lines[0];
        $keys = str_replace(' ','',$keys);
        $keys = explode(';',$keys);
        $records = [];
        $data[] = [];
        $eye_types = [
            'Right' => 'od',
            'Left' => 'os'
        ];
        for($i=1;$i<sizeof($lines) - 1;$i++)
        {
            $records[$i] = [];
            $data[$i] = [];
            $lines[$i] = str_replace(' ','',$lines[$i]);

            $line = explode(';',$lines[$i]);

            for ($j = 0;$j < sizeof($keys);$j++)
            {
                if(is_numeric($line[$j]))
                {
                    $data[$i]['prescription_id'] = $line[$j];
                    $j = sizeof($keys);
                }
            }

            for ($n = 0;$n < sizeof($keys);$n++)
            {
                $keys[$n] = str_replace(":","",$keys[$n]);
                $records[$i][$keys[$n]] = $line[$n];
            }

            $patient_id = MedicalRecord::where('prescription_id',$data[$i]['prescription_id'])->first()->patient_id;
            $records[$i]['ExamEye'] = $eye_types[$records[$i]['ExamEye']];
            $eyeVariableService = new EyeVariableService('pentacam',$patient_id,$records[$i]['ExamEye']);

            isset($records[$i]['Axis(flat)']) && $eyeVariableService->set('Axis_flat',$records[$i]['Axis(flat)']);
            isset($records[$i]['PupilX']) && $eyeVariableService->set('PupilX',$records[$i]['PupilX']);
            isset($records[$i]['PupilY']) && $eyeVariableService->set('PupilY',$records[$i]['PupilY']);
            isset($records[$i]['PachyMin']) && $eyeVariableService->set('pachy_min', $records[$i]['PachyMin']);
            isset($records[$i]['PachyMinX']) && $eyeVariableService->set('PachyMinX',$records[$i]['PachyMinX']);
            isset($records[$i]['PachyMinY']) && $eyeVariableService->set('PachyMinY',$records[$i]['PachyMinY']);
            isset($records[$i]['ACDepth']) && $eyeVariableService->set('ac_depth',$records[$i]['ACDepth']);
            isset($records[$i]['K1(D)']) && $eyeVariableService->set('K1_D',$records[$i]['K1(D)']);
            isset($records[$i]['K2(D)']) && $eyeVariableService->set('K2_D',$records[$i]['K2(D)']);
            isset($records[$i]['Astig']) && $eyeVariableService->set('astig_topo',$records[$i]['Astig']);
            isset($records[$i]['KmF(D)']) && $eyeVariableService->set('KM_D',$records[$i]['KmF(D)']);
            isset($records[$i]['PupilPosX']) && $eyeVariableService->set('PupilX',$records[$i]['PupilPosX']);
            isset($records[$i]['PupilPosY']) && $eyeVariableService->set('PupilY',$records[$i]['PupilPosY']);
            isset($records[$i]['Rf']) && $eyeVariableService->set('rf',$records[$i]['Rf']);
            isset($records[$i]['Rs']) && $eyeVariableService->set('rs',$records[$i]['Rs']);

             $mixed_data = EyeVariable::where('eye_type',$records[$i]['ExamEye'])->where('patient_id',$patient_id)->first()->mixed_data;

             $old_mixed_data = (array) json_decode($mixed_data);
            unset($records[$i]['FirstName']);
            unset($records[$i]['LastName']);
            $records[$i]['Pat-ID'] = $patient_id;
            $eyeVariableService->set('mixed_data',json_encode([...$records[$i],...$old_mixed_data]));

        }



    }
}
