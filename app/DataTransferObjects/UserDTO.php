<?php

namespace App\DataTransferObjects;

class UserDTO
{
    private array $toArray;
    public function __construct(
        public ?string $national_code,
        public ?string $email,
        public ?string $mobile,
        public ?string $password,
        public ?string $avatar,
        public ?string $firstname,
        public ?string $lastname,
        public ?string $birth_date,
        public ?string $userCollectionId ,
        public ?string $gender = "FEMALE"
    )
    {
        $this->toArray = [
            'national_code' => $this->national_code,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'password' => $this->password,
            'avatar' => $this->avatar,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'birth_date' => $this->birth_date,
            'gender' => $this->gender,
            'user_collection_id' => $this->userCollectionId
        ];
    }

    public function toArray() : array
    {
        return  $this->toArray;
    }

    public function set($parameter,$value) : void
    {
        $this->$parameter = $value;
        $this->toArray[$parameter] = $value;
    }
}
