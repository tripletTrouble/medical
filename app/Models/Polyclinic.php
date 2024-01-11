<?php

namespace App\Models;

use App\Traits\MedicalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Polyclinic extends Model
{
    use HasFactory, MedicalModel;

    public function practitioners(): BelongsToMany
    {
        return $this->belongsToMany(Practitioner::class);
    }
}
