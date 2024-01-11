<?php

namespace App\Policies;

use App\Models\Polyclinic;
use App\Models\User;
use App\Traits\AdminPolicy;
use Illuminate\Auth\Access\Response;

class PolyclinicPolicy
{
    use AdminPolicy;
}
