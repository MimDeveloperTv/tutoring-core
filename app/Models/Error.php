<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Error extends Model
{
    protected $fillable = ['route','status'];

    public function messages() : HasMany
    {
        return $this->hasMany(ErrorMessage::class);
    }
}
