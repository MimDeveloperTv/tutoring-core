<?php

namespace App\Http\Controllers\Global;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();
           try {
            $user = User::create([
                'national_code' => $request->national_code,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'password' => $request->password,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'birth_date' => Carbon::now(),
             ]);

             $user->personnel()->create([
                 'firstname' => $request->firstname,
                 'lastname' => $request->lastname,
             ]);

             DB::commit();
             return response()->json([
                'message' => 'admin created successfully'
            ]);

           } catch (\Throwable $th) {
            DB::rollBack();
             return response()->json([
                'message' => $th->getMessage()
            ]);
           }




    }
}
