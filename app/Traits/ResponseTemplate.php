<?php

namespace App\Traits;
trait ResponseTemplate
{
    private $data = [];
    private $status = 200;
    private $errors = [];

    public function setStatus(int $status) : void
    {
         $this->status = $status;
    }

    public function setData($data) : void
    {
        $this->data = $data;
    }

    public function setErrors($errors) : void
    {
        $this->errors = $errors;
    }

    public function response(string $platform = 'web') : object
    {

        switch ($platform) {
            case 'app':
                return response()->json(['data' => $this->data,'errors' => $this->errors,'status' => $this->status],$this->status);
                break;
            default:
                  return response()->json(['data' => $this->data,'errors' => $this->errors],$this->status);
                break;
        }
    }
}
