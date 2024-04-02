<?php

namespace App\Http\Requests;

use App\Enums\GendersEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class PatientRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'firstname' => [
                'required',
                'min:3'
            ],
            'lastname' => [
                'required',
                'min:3'
            ],
            'age' => [
                'nullable',
                'integer'
            ],
            'gender' => [
                'nullable',
                new Enum(GendersEnum::class),
            ],
            'mobile' => [
                'required',
                'string',
                // 'regex:/+?98|098|0|0098)?(9\d{9}/g'
            ],
            'email' => [
                'nullable',
                'email',
            ],
            'password' => [
                'nullable',
                'min:8',
                'alpha_num:ascii'
            ],
            'national_code' => [
                'required',
                // 'regex:/^[0-9]{10}$/g',
            ]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
