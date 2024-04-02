<?php

namespace App\Models\Hard\Eye;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiDiagnosis extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'eye_type',
        'pentacam',
        'eyesys',
        'grade'
    ];

    public function patient() : BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
