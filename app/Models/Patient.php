<?php

namespace App\Models;

use App\Models\Hard\Eye\EyeVariable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $fillable = [
        'id',
        'user_id',
    ];
    protected $keyType = 'uuid';

    // protected static function boot(): void
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
    //     });
    // }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch(Builder $query)
    {
        return $query->when(request()?->filled('term'), fn(Builder $outerQuery) => $outerQuery
            ->where('firstname', 'like', '%' . request()->term . '%')
            ->orWhere('firstname', 'like', '%' . request()->term . '%')
            ->orWhereHas('user', fn(Builder $innerQuery) => $innerQuery
                ->where('national_code', 'like', '%' . request()->term . '%'))
        );
    }

    public function eye_variables() : HasMany
    {
        return $this->hasMany(EyeVariable::class);
    }

    public function medical_history() : HasOne
    {
        return $this->hasOne(MedicalHistory::class);
    }
}
