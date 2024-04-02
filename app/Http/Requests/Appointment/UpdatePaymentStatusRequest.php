<?php

namespace App\Http\Requests\Appointment;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'payment_status' => 'required|in:SUCCESS,FAILED,PENDING'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
