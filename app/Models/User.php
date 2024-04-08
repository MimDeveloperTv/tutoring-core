<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Ramsey\Uuid\Uuid;

class User extends Authenticatable
{
    use HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mobile',
        'email',
        'password',
        'national_code',
        'gender',
        'avatar',
        'firstname',
        'lastname',
        'birth_date',
        'gender',
        'user_collection_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $keyType = 'uuid';

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }

    public function patient() : HasOne
    {
        return $this->hasOne(Patient::class);
    }

    public function operators() : HasOne
    {
        return $this->hasOne(Operator::class);
    }

    public function personnel() : HasOne
    {
        return $this->hasOne(Personnel::class);
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




}
