<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;
use Spatie\MediaLibrary\InteractsWithMedia;

class Operator extends Model
{
    use HasFactory,SoftDeletes,InteractsWithMedia;
    protected $fillable = [
        'id',
        'user_id'
    ];
    protected $keyType = 'uuid';

    public $incrementing = false;

    public function prescriptions() : BelongsToMany
    {
        return $this->belongsToMany(Prescription::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
