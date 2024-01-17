<?php

namespace App\Models;

use App\Traits\InteractsWithMeasures;
use App\Traits\MedicalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory, MedicalModel, InteractsWithMeasures;

    public function measures(): HasMany
    {
        return $this->hasMany(ItemMeasure::class);
    }
}
