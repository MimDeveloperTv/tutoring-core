<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Personnel extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [ 'user_id','firstname','lastname'];

    protected $keyType = 'uuid';

    public $incrementing = false;

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
