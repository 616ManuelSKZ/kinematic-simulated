<?php

namespace App\Policies;

use App\Models\Experimento;
use App\Models\User;

class ExperimentoPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Experimento $experimento): bool
    {
        return $user->id === $experimento->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Experimento $experimento): bool
    {
        return $user->id === $experimento->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Experimento $experimento): bool
    {
        return $user->id === $experimento->user_id;
    }
}