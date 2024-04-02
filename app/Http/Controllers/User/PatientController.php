<?php

namespace App\Http\Controllers\User;

use App\DataTransferObjects\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\PatientRequest;
use App\Http\Resources\PatientResource;
use Illuminate\Http\Request;
use App\Models\MedicalHistory;
use App\Models\Patient;
use App\Models\User;
use App\Services\UserService;
use App\Traits\ResponseTemplate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use App\Lib\Http\Request as CustomRequest;

class PatientController extends Controller
{
    use ResponseTemplate;

    public function __construct(public UserService $userService)
    {

    }

    public function index(Request $request)
    {
        $patients = Patient::query()->when($request['name'], function ($query) use ($request) {
            return $query->whereHas('user', function ($query) use ($request) {
                return $query->where('firstname', 'LIKE', '%' . $request->input('name') . '%')->orWhere('lastname', 'LIKE', '%' . $request->input('name') . '%');
            });
        })->when($request['mobile'], function ($query) use ($request) {
            return $query->whereHas('user', function ($query) use ($request) {
                return $query->where('mobile', 'LIKE', '%' . $request->input('mobile') . '%');
            });
        })->when($request['national_code'], function ($query) use ($request) {
            return $query->whereHas('user', function ($query) use ($request) {
                return $query->where('national_code', 'LIKE', '%' . $request->input('national_code') . '%');
            });
        })->orderBy('created_at', 'DESC')
            ->paginate($request->pagination ?? 10);

        return PatientResource::collection($patients);
    }

    public function store(PatientRequest $request)
    {
     
        // try {
            $user = $this->userService->findOrCreateByNationalCode(new UserDTO(
                $request->national_code,
                $request->email,
                $request->mobile,
                $request->password,
                $request->avatar,
                $request->firstname,
                $request->lastname,
                $request->birth_date,
                $request->gender
            ));

            $patient = Patient::whereUserId($user->id)->first();
            if ($patient) {
                $this->setData(new PatientResource($patient));
                return $this->response();
            }

//                $this->setErrors([
//                    'national_code' => 'A patient with this national ID has already been registered'
//                ]);

            \Log::debug(config("services.iam.api_key"));
                    
            $booking_patient_response = CustomRequest::post([
                'api-key' => config("services.iam.api_key"),
            ], [
                'user_id' => $user->id,
                'fullname' => $user->firstname . " " . $user->lastname,
            ], 'booking', '/collections/consumers');
            
        // } catch (\Throwable $th) {
        //     $this->setStatus(400);
        //     $this->setErrors($th->getMessage());
        //     return $this->response();
        // }

        $this->setStatus($booking_patient_response->status());
        if ($booking_patient_response->status() == 201) {
            $booking_patient_id = json_decode($booking_patient_response->body())->data->id;
          
            DB::transaction(function () use ($user, $booking_patient_id) {
                $patient = Patient::create([
                    'id' => $booking_patient_id,
                    'user_id' => $user->id,
                ]);

                $patient->medical_history()->create();

                $patient->eye_variables()->create(['eye_type' => 'od']);
                $patient->eye_variables()->create(['eye_type' => 'os']);

                if ($patient) {
                    $this->setData(new PatientResource($patient));
                } else {
                    $this->setErrors([
                        'message' => 'ERRIR! Database Error : User not created.'
                    ]);
                    $this->setStatus(500);
                }
            }, 3);
        } else {
            try {
                $this->setErrors($booking_patient_response->body());
            } catch (\Exception $exception) {
                $this->setErrors(['code' => 'core-clinic : patientController : code : 78958641', 'error' => $booking_patient_response]);
            }
        }

        // $patient = DB::transaction(fn() => User::create([
        //     'mobile' => $request->input('mobile'),
        //     'email' => $request->input('email'),
        //     'password' => Hash::make($request->input('password', $request->input('national_code'))),
        //     'national_code' => $request->input('national_code'),
        // ])->patient()->create(
        //     $request->validated()
        // ));

        return $this->response();
    }

    public function show(Patient $patient): PatientResource
    {
        return new PatientResource($patient);
    }

    public function update(PatientRequest $request, Patient $patient): PatientResource
    {
        return new PatientResource($patient->update($request->validated()));
    }

    public function destroy(Patient $patient): JsonResponse
    {
        $patient->delete();

        return response()->json([
            'message' => __('Patient deleted successfully')
        ], ResponseAlias::HTTP_NO_CONTENT);
    }
}
