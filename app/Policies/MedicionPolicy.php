<?php

namespace App\Policies;

use App\Models\Medicion;
use App\Models\User;

class MedicionPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Medicion $medicion): bool
    {
        return $user->id === $medicion->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Medicion $medicion): bool
    {
        return $user->id === $medicion->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Medicion $medicion): bool
    {
        return $user->id === $medicion->user_id;
    }
}