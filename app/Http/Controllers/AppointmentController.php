<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\UpdateAppointmentJobDTO;
use App\Http\Requests\Appointment\UpdatePaymentStatusRequest;
use App\Http\Requests\Appointment\UpdateStatusRequest;
use App\Http\Resources\ReserveCollection;
use App\Jobs\UpdateBookingAppointmentJob;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {

        $reserves = Appointment::when($request['flag'] == 'today',function ($query){
            $today = Carbon::now()->format('Y-m-d');
            $todayTimeStamp = Carbon::createFromFormat('Y-m-d H:i:s',$today." 00:00:00")->getTimestamp();
            return $query->whereBetween('from',[$todayTimeStamp,$todayTimeStamp+86400]);
        })->when($request['patient_name'],function ($query)use ($request){
            return $query->whereHas('patient',function ($query)use ($request){
                return $query->whereHas('user',function ($query)use ($request){
                    $firstName = explode(' ',$request->input('patient_name'))[0];
                    $lastName = explode(' ',$request->input('patient_name'))[1] ?? explode(' ',$request->input('patient_name'))[0];
                    return $query->where('firstname','LIKE',"%$firstName%")->orWhere('lastname','LIKE',"%$lastName%");
                });
            });
        })->when($request['operator_name'],function ($query)use ($request){
            return $query->whereHas('operator',function ($query)use ($request){
                return $query->whereHas('user',function ($query)use ($request){
                    $firstName = explode(' ',$request->input('operator_name'))[0];
                    $lastName = explode(' ',$request->input('operator_name'))[1] ?? explode(' ',$request->input('operator_name'))[0];
                    return $query->where('firstname','LIKE',"%$firstName%")->orWhere('lastname','LIKE',"%$lastName%");
                });
            });
        })->when($request['payment_status'],function ($query)use ($request){
            return $query->where('payment_status',$request->input('payment_status'));
        })->when($request['status'],function ($query)use ($request){
            return $query->where('status',$request->input('status'));
        })->when($request['reserved_from'] && $request['reserved_to'],function ($query)use ($request){
            return $query->whereBetween('from',[
                Carbon::createFromFormat('Y-m-d H:i:s',$request->input('reserved_from')." 00:00:00")->getTimestamp(),
                Carbon::createFromFormat('Y-m-d H:i:s',$request->input('reserved_to')." 23:59:59")->getTimestamp()
            ]);
        })->when($request['amount_from'] && $request['amount_to'],function ($query)use ($request){
            return $query->whereBetween('amount',[$request->input('amount_from'),$request->input('amount_to')]);
        })->when($request['service_name'],function ($query)use ($request){
            return $query->where('service','LIKE','%'.$request->input('service_name').'%');
        })->orderBy('from', 'desc')->paginate($request->input('pagination') ?? 10);
        $this->setData(new ReserveCollection($reserves));
        return $this->response();
    }

    public function updateStatus(UpdateStatusRequest $request,$id)
    {
        try {
            Appointment::findOrFail($id)->update([
                'status' => $request->input('status')
            ]);
            $appointment = Appointment::find($id);
            UpdateBookingAppointmentJob::dispatch(new UpdateAppointmentJobDTO(
                $appointment->id,
                $appointment->booking_id,
                $appointment->status,
                $appointment->payment_status
            ))->onQueue('default');
            return $this->response();
        }catch (\Exception $exception){
            $this->setErrors(['errors' => $exception->getMessage()]);
            $this->setStatus(500);
            return $this->response();
        }
    }

    public function updatePaymentStatus(UpdatePaymentStatusRequest $request,$id)
    {
        try {
            Appointment::findOrFail($id)->update([
                'payment_status' => $request->input('payment_status')
            ]);
            $appointment = Appointment::find($id);
            UpdateBookingAppointmentJob::dispatch(new UpdateAppointmentJobDTO(
                $appointment->id,
                $appointment->booking_id,
                $appointment->status,
                $appointment->payment_status
            ))->onQueue('default');
            return $this->response();
        }catch (\Exception $exception){
            $this->setErrors(['errors' => $exception->getMessage()]);
            $this->setStatus(500);
            return $this->response();
        }
    }

}
