<?php

namespace App\Http\Controllers;

use App\Lib\Http\Request as CustomRequest;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use App\Services\SurgeryCalculationService;
class AppointmentOccurredController extends Controller
{
    public function newAppointment(Request $request)
    {
        Appointment::create([
            'id' => $request->input('booking_id'),
            'patient_id' => $request->input('consumer_id'),
            'operator_id' => $request->input('requested_by'),
            'service' => $request->input('service_model')['name'].'-'.$request->input('service_model_item')['label'],
            'status' => $request->input('status'),
            'payment_status' => $request->input('payment_status'),
            'amount' => $request->input('amount'),
            'currency' => $request->input('currency'),
            'place' => $request->input('address')['title'],
            'address' => $request->input('address')['description'],
            'from' => $request->input('from'),
            'to' => $request->input('to'),
        ]);
        if($request->service_model['calculation'])
        {
            $sergeryCalculationService = new SurgeryCalculationService($request->consumer_id,$request->service_model_item['label'],$request->service_model['calculation']);
            $record = json_encode($sergeryCalculationService->getSurgeryData());
        }
        else
        {
            $response = CustomRequest::get([
                'api-key' => config("services.form_builder.api_key")
            ],[

            ],'form_builder',"/forms/".$request->service_model['form_id']);

            if($response->status() == 200)
            {
                $record = json_encode(json_decode($response->body())->data);
            }
            else
            {
                $record = $response->status()."===".$response->body();
            }
        }
        \Log::info($request->all());
        MedicalRecord::create([
            'patient_id' => $request->consumer_id,
            'prescriber_id' => $request->requested_by ?? $request->accepted_by,
            'prescription_id' => $request->service_request_id,
            'prescription_type' => $request->service_request_type,
            'prescription_name' => $request->service_model['name'],
            'service_item' => $request->service_model_item['label'],
            'operator_id' => $request->accepted_by,
            'status' => 'NEW',
            'record' => $record,
            'calculation' => $request->service_model['calculation'],
        ]);
        return response()->json([],200);
    }
}
