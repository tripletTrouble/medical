<?php

namespace App\Models;

use App\Traits\MedicalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemMeasure extends Model
{
    use HasFactory, MedicalModel;

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    
}
