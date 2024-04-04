<?php

namespace App\Http\Controllers;


use App\Http\Resources\PatientResource;
use App\Http\Resources\OperatorCollection;
use App\Traits\ResponseTemplate;
use App\Models\Personnel;
use Illuminate\Http\Client\Request;

class PersonnelController extends Controller
{
    use ResponseTemplate;
    public function __construct()
    {}

    public function index()
    {
        $personnels = Personnel::all();
        return response()->json(OperatorCollection::collection($personnels));
    }
    public function show($id)
    {
        $personnel = Personnel::query()->find($id);
        return response()->json(['personnel' => new PatientResource($personnel)]);
    }
}
