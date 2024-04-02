<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Reserve */
class ReserveResource extends JsonResource
{
    public function toArray(Request $request)
    {
        $currency = [
            'IR-RIAL' => 'ريال',
            'US-DOLLAR' => '$'
        ];
        return [
            'id' => $this->id,
            'payment_status' => $this->payment_status,
            'status' => $this->status,
            'amount' => $this->amount,
            'currency' => $currency[$this->currency],
            'from' => Carbon::createFromTimestamp( $this->from)->format('Y-m-d H:i'),
            'to' => Carbon::createFromTimestamp( $this->to)->format('Y-m-d H:i'),
            'created_at' => $this->created_at->format('Y-m-d H:i'),
//            'updated_at' => $this->updated_at,
            'patient' => new PatientResource($this->patient),
            'operator' => new OperatorResource($this->operator),
            'service_name' => $this->service,
        ];
    }
}
