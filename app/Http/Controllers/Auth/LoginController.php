<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function Authenticate(Request $request)
    {
        $request->validate([ 'password' => 'required', 'mobile' => 'required'],[]);
        $user = User::query()->where('mobile',$request->mobile)
            ->where(function($query){
                $query->whereHas('personnel')->OrwhereHas('operators');}
            )->first();
        if ($user && Hash::check($request->password, $user->password)) {
                $types = [];
                $user->personnel ? array_push($types,'PERSONNEL') : null;
                $user->operators ? array_push($types,'OPERATOR') : null;

                return response()->json(['user' => $user]);
            }

        return response()->json(['message' => 'Unauthorized'], 401);

    }
}
