<?php

namespace App\Models;

use App\Traits\MedicalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Practitioner extends Model
{
    use HasFactory, MedicalModel;

    protected $casts = ['details' => 'array'];

    public function polyclinics(): BelongsToMany
    {
        return $this->belongsToMany(Polyclinic::class)->withTimestamps();
    }
}