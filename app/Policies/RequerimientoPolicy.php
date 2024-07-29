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

    public function autor(User $user, Requerimiento $reque)
    {
        $hasCarrera = $user->carreras->contains($reque->carrera_id);

        return $user->rol->nombre === 'Jefe de carrera' || 
               $user->rol->nombre === 'Dir Administrativo' ||
               ($user->rol->nombre === 'Coordinador de carrera' && $hasCarrera)||
               ($user->rol->nombre === 'Docente de la institución' && $hasCarrera);
    }
}
