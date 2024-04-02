<?php

namespace App\Http\Controllers\User;

use App\DataTransferObjects\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Resources\OperatorCollection;
use App\Http\Resources\OperatorResource;
use App\Models\Operator;
use App\Models\User;
use App\Services\UserService;
use App\Traits\ResponseTemplate;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Lib\Http\Request as CustomRequest;

class OperatorController extends Controller
{
    use ResponseTemplate;

    public function __construct(public UserService $userService)
    {

    }

    public function index(Request $request)
    {
        $operators = Operator::query()->when($request['name'], function ($query) use ($request) {
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

        return OperatorCollection::collection($operators);

    }

    public function store(Request $request)
    {
//        $request->validate([
//            'national_code' => 'required',
//            'mobile' => 'required',
//            'email' => 'required',
//            'password' => 'required',
//            'firstname' => 'required',
//            'lastname' => 'required',
//            'avatar' => 'required'
//        ]);

        try {
            $user = $this->userService->findOrCreateByNationalCode(new UserDTO(
                $request->national_code,
                $request->email,
                $request->mobile,
                $request->password,
                $request->avatar,
                $request->firstname,
                $request->lastname,
                $request->birth_date
            ));

            $operator = Operator::where('user_id', $user->id)->first();
            if ($operator) {
                $this->setData(new OperatorResource($operator));
                return $this->response();
            }

            $booking_operator_response = CustomRequest::post([
                'api-key' => config("services.iam.api_key"),
            ], [
                'fullname' => $user->firstname . " " . $user->lastname,
                'user_id' => $user->id
            ], 'booking', '/collections/operators');
        } catch (\Throwable $th) {
            $this->setStatus(400);
            $this->setErrors($th->getMessage());
            return $this->response();
        }


        $this->setStatus($booking_operator_response->status());
        if ($booking_operator_response->status() == 201) {
            $booking_operator_id = json_decode($booking_operator_response->body())->data->id;
            DB::transaction(function () use ($user, $booking_operator_id) {
                $operator = Operator::create([
                    'id' => $booking_operator_id,
                    'user_id' => $user->id,
                ]);

                if ($operator) {
                    $this->setData(new OperatorResource($operator));
                } else {
                    $this->setErrors([
                        'message' => 'ERRIR! Database Error : User not created.'
                    ]);
                    $this->setStatus(500);
                }
            }, 3);
        } else {
            try {
                $this->setErrors($booking_operator_response->body());
            } catch (\Exception $exception) {
                $this->setErrors($booking_operator_response);
            }
        }

        return $this->response();
    }

    public function show($id)
    {
        $operator = Operator::find($id);
        return response()->json(['operator' => new OperatorResource($operator)]);
    }

}
