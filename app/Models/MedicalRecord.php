<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'prescriber_id',
        'prescription_id',
        'prescription_type',
        'prescription_name',
        'service_item',
        'operator_id',
        'status',
        'record',
        'calculation'
    ];
}
