<?php

namespace App\Policies;

use App\Models\Test;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TestPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Test $test): bool
    {
        return $test->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Test $test): bool
    {
        return $test->user_id === $user->id;
    }
}
