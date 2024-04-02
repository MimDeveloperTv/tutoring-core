<?php

namespace App\Models;

use App\Factories\PlanningConditionFactory;
use App\Services\PlanningConditionService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected function errors(): Attribute
    {
        return Attribute::make(
            get: fn($value, array $attributes) => !is_null($this->condition) ? PlanningConditionFactory::build($this->condition) : [],
            set: fn($value) => $value,
        );
    }
}
