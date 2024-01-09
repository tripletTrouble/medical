<?php

namespace App\Models;

use App\Traits\MedicalModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RecipeOrder extends Model
{
    use HasFactory, MedicalModel;
}
