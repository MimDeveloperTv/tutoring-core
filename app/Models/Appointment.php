<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Appointment extends Model
{
    use HasFactory,SoftDeletes;
    protected $keyType = 'uuid';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'operator_id',
        'patient_id',
        'payment_status',
        'status',
        'amount',
        'currency',
        'from',
        'to',
        'service',
        'place',
        'address'
    ];

    public function operator() : BelongsTo
    {
        return $this->belongsTo(Operator::class);
    }

    public function patient() : BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

}
