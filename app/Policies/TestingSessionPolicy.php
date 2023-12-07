<?php

namespace App\Policies;

use App\Models\Exam;
use App\Models\TestingSession;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TestingSessionPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user = null): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user = null, TestingSession $testingSession, Exam $exam = null): bool
    {
        if ($user && $testingSession->user && $testingSession->user->id !== $user->id) return false;
        return true;
    }

    public function complete(User $user = null, TestingSession $testingSession, Exam $exam = null): bool
    {
        if ($user && $testingSession->user && $testingSession->user->id !== $user->id) return false;
        return true;
    }
}
