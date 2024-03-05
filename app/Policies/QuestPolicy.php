<?php

namespace App\Policies;

use App\Models\Quest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class QuestPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Quest $quest): bool
    {
	    return $user->id === $quest->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Quest $quest): bool
    {
	    return $user->id === $quest->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Quest $quest): bool
    {
	    return $user->id === $quest->user_id;
    }
}
