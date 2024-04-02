<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\OperatorResource;
use App\Http\Resources\PatientResource;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\OperatorService;
use App\Traits\ResponseTemplate;

class UserOperatorController extends Controller
{
    use ResponseTemplate;
    public function __construct(public OperatorService $operatorService)
    {
    }

    public function show($user_id)
    {
         $operator = User::find($user_id)->operators;
        if($operator)
            $this->setData(new OperatorResource($operator));
        else
        {
            $this->setStatus(400);
            $this->setErrors([
                'message' => 'there are no operator with this user_id '
            ]);
        }
        return $this->response();
    }

    public function store(Request $request,$user_id)
    {
        $operator = $this->operatorService->new($user_id);
        if($operator)
        {
            $this->setData(new OperatorResource($operator));
            return $this->response();
        }

        $this->setStatus( 500);
        $this->setErrors([
            'message' => 'server error'
        ]);
        return $this->response();
    }
}
