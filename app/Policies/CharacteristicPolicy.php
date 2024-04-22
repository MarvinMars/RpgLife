<?php

namespace App\Policies;

use App\Models\Characteristic;
use App\Models\User;

class CharacteristicPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Characteristic $quest): bool
    {
        return $user->id === $quest->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Characteristic $quest): bool
    {
        return $user->id === $quest->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Characteristic $quest): bool
    {
        return $user->id === $quest->user_id;
    }
}
