<?php

namespace App\Http\Controllers;

use App\Events\MedicalFormRecorded;
use App\Http\Resources\MedicalRecordListResource;
use App\Http\Resources\MedicalRecordResource;
use App\Models\Hard\Eye\EyeVariable;
use App\Services\SurgeryCalculationService;
use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Traits\ResponseTemplate;
use App\Lib\Http\Request as CustomRequest;

class MedicalFormController extends Controller
{
    use ResponseTemplate;

    public function create(Request $request)
    {
//        if($request->service_model['calculation'])
//        {
//           $sergeryCalculationService = new SurgeryCalculationService($request->consumer_id,$request->service_model_item['label'],$request->service_model['calculation']);
//           $record = json_encode($sergeryCalculationService->getSurgeryData());
//        }
//        else
//        {
//            $response = CustomRequest::get([
//                'api-key' => config("services.form_builder.api_key")
//            ],[
//
//            ],'form_builder',"/forms/".$request->service_model['form_id']);
//
//            if($response->status() == 200)
//            {
//                $record = json_encode(json_decode($response->body())->data);
//            }
//            else
//            {
//                $record = $response->status()."===".$response->body();
//            }
//        }
//        MedicalRecord::create([
//            'patient_id' => $request->consumer_id,
//            'prescriber_id' => $request->requested_by ?? $request->accepted_by,
//            'prescription_id' => $request->service_request_id,
//            'prescription_type' => $request->service_request_type,
//            'prescription_name' => $request->service_model['name']." - ".$request->service_model_item['label'],
//            'service_item' => $request->service_model_item['label'],
//            'operator_id' => $request->accepted_by,
//            'status' => 'NEW',
//            'record' => $record,
//        ]);
//        return response()->json([],200);
    }
    public function index(Request $request)
    {
         if(request()->has('flag') && $request->flag = 'recorded')
         {
             $medical_recored = MedicalRecord::where('status','=','SUBMIT')->where('patient_id',$request->patient_id)->get();
             $this->setData(MedicalRecordListResource::collection($medical_recored));
         }
         elseif(isset($request->type) && $request->type == 'TREATMENT')
         {
             $medical_forms = MedicalRecord::where('status','!=','SUBMIT')->where('patient_id',$request->patient_id)->where('prescription_type','TREATMENT')->get();
             $this->setData(MedicalRecordListResource::collection($medical_forms));
         }
         else
         {
             $medical_forms = MedicalRecord::where('status','!=','SUBMIT')->where('patient_id',$request->patient_id)->where('prescription_type','!=','TREATMENT')->get();

             $this->setData(MedicalRecordListResource::collection($medical_forms));
         }
         return $this->response();
    }
    public function show($id)
    {
        $medical_forms = MedicalRecord::find($id);
        $this->setData(new MedicalRecordResource($medical_forms));
        return $this->response();
    }

    public function submit(Request $request,$id)
    {

        $request->validate([
            'record' => 'required',
        ]);
        $medical_form =  MedicalRecord::find($id);
        if($request->record['optometry'] ?? false)
        {
            foreach ($request->record['optometry'] as $eye_type => $variables)
            {
                $this->setData(['eye_type' => $eye_type,'variable' => $variables]);
                EyeVariable::where('patient_id',$medical_form->patient_id)
                    ->where('eye_type',$eye_type)->update([
                        'K1_D' => $variables['k_reading']['k1'],
                        'K2_D' => $variables['k_reading']['k2'],
                        'pachy_min' => $variables['pachymetry'],
                        'KM_D' => ($variables['k_reading']['k1'] + $variables['k_reading']['k2']) / 2,
                        'astig_topo' => $variables['k_reading']['k1'] - $variables['k_reading']['k2'],
                        'Axis_flat' => $variables['k_reading']['axis'],
                        'subjective_ref_sph' => $variables['subjectiveRef']['sph'],
                        'subjective_ref_cyl' => $variables['subjectiveRef']['cyl'],
                        'subjective_ref_axis' => $variables['subjectiveRef']['axis'],
                        'subjective_ref_bcva' => $variables['subjectiveRef']['bcva'],
                        'optometry_ucva' => $variables['usva'],
                        ]);
            }
            $calculationMedicalForms = MedicalRecord::where('patient_id',$medical_form->patient_id)
                ->where('status','=','NEW')->whereNotNull('calculation')->get();
            foreach ($calculationMedicalForms as $form)
            {
                $surgeryCalculationService = new SurgeryCalculationService($medical_form->patient_id,$form->item,$form->calculation);
                $record = json_encode($surgeryCalculationService->getSurgeryData());
                MedicalRecord::find($form->id)->update([
                    'record' => $record
                ]);
            }
        }
        if($medical_form->status != 'SUBMIT')
        {
             $medical_form->record = $request->record;
             $medical_form->status = 'SUBMIT';
             $medical_form->save();
             $this->setStatus(202);
        }
        else
        {
            $this->setErrors([
                'message' => 'فرم ثبت شده و امکان ویرایش وجود ندارد'
            ]);
            $this->setStatus(422);
        }
        return $this->response();
    }

    public function draft(Request $request,$id)
    {
        $request->validate([
            'record' => 'required',
        ]);
        $medical_form =  MedicalRecord::find($id);

        if($medical_form->status != 'SUBMIT')
        {
            $medical_form->record = $request->record;
            $medical_form->status = 'DRAFT';
            $medical_form->save();

            $this->setStatus(202);
        }
        else
        {
            $this->setErrors([
                'message' => 'فرم ثبت شده و امکان ویرایش وجود ندارد'
            ]);
            $this->setStatus(422);
        }
        return $this->response();
    }

}
