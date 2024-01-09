<?php

namespace App\Traits;
use Illuminate\Database\Eloquent\SoftDeletes;

trait MedicalModel
{
    use SoftDeletes;
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at', 'banned_at'];
}