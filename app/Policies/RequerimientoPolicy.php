<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Requerimiento;
use Illuminate\Auth\Access\HandlesAuthorization;


class RequerimientoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create requerimientos.
     */
    public function create(User $user)
    {
        return $user->rol->nombre != 'Docente de la institución';
    }
}
