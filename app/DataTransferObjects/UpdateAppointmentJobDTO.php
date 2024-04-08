<?php

namespace App\DataTransferObjects;

class UpdateAppointmentJobDTO
{
    private array $toArray;
    public function __construct(
        public ?string $id,
        public ?string $status,
        public ?string $payment_status,
    )
    {
        $this->toArray = [
            'national_code' => $this->id,
            'mobile' => $this->status,
            'password' => $this->payment_status,
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
