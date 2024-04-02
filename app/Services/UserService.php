<?php

namespace App\Services;

use App\DataTransferObjects\UserDTO;
use App\Models\User;

class UserService
{
    public function new(UserDTO $userDTO) : ?User
    {
        return User::create($userDTO->toArray());
    }

    public function findOrCreateByNationalCode(UserDTO $userDTO) : User
    {
         return User::firstOrCreate(['national_code' => $userDTO->national_code],$userDTO->toArray());
    }

//    public function findByNationalCode(string $national_code) : ?User
//    {
//        return User::whereNationalCode($national_code)->first();
//    }
}
