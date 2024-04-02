<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MedicalHistory;
use App\Models\User;
use App\Http\Resources\Patient\MedicalHistoryResource;
class MedicalHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $patient_id = User::find($id)->patient->id;
        
        $medicalHistory = MedicalHistory::where('patient_id', $id)->first();
        // dd($medicalHistory);

        $this->setData(new MedicalHistoryResource($medicalHistory));

        return $this->response();

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $MedicalHistory = MedicalHistory::find($id)
            ->update([
                "dryness" => $request->dryness,
                "chronic_tearing" => $request->chronic_tearing,
                "chronic_allergy" => $request->chronic_allergy,
                "blepharitis" => $request->blepharitis,
                "contact_lens_use" => $request->contact_lens_use,
                "recurrent_corneal_erosion" => $request->recurrent_corneal_erosion,
                "previous_ocular_trauma" => $request->previous_ocular_trauma,
                "previous_ocular_surgery" => $request->previous_ocular_surgery,
                "any_other_ocular_diseases" => $request->any_other_ocular_diseases,
                "diabetes" => $request->diabetes,
                "blood_pressure" => $request->blood_pressure,
                "known_medication_allergy" => $request->known_medication_allergy,
                "known_allergy_to_food_metals_or_others" => $request->known_allergy_to_food_metals_or_others,
                "collagen_systemic_diseases" => $request->collagen_systemic_diseases,
                "use_of_anti_coagulants" => $request->use_of_anti_coagulants,
                "or_steroids" => $request->or_steroids,
                "or_isotretinoin" => $request->or_isotretinoin,
                "or_immunosuppressant" => $request->or_immunosuppressant,
                "or_sumatriptan" => $request->or_sumatriptan,
                "pregnancy" => $request->pregnancy,
                "lactation" => $request->lactation,
            ]);

        $medicalHistory = MedicalHistory::find($id);

        $this->setData($medicalHistory);
        $this->setStatus(201);

        return $this->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $this->setData("done");
        // return $this->response();
    }
}
