<?php

namespace App\Models;

use App\Traits\MedicalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    use HasFactory, MedicalModel;
}
