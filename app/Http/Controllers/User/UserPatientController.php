<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\PatientResource;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\PatientService;
use App\Traits\ResponseTemplate;

class UserPatientController extends Controller
{
    use ResponseTemplate;
    public function __construct(public PatientService $patientService)
    {
    }

    public function show($user_id)
    {
        $patient = User::find($user_id)->patient;
        if($patient)
            $this->setData(new PatientResource($patient));
        else
        {
            $this->setStatus(400);
            $this->setErrors([
                'message' => 'there are no patients with this user_id '
            ]);
        }
         return $this->response();
    }

    public function store(Request $request)
    {
        $patient = $this->patientService->new($request->user_id);
        if($patient)
        {
            $this->setData(new PatientResource($patient));
            return $this->response();
        }

        $this->setErrors(500);
        $this->setErrors([
            'message' => 'server error'
        ]);
        return $this->response();
    }
}
