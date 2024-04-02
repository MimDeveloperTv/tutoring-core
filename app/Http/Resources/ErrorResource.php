<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Error */
class ErrorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'route' => $this->route,
            'status' => $this->status,
            'messages' => ErrorMessageResource::collection($this->errors),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
