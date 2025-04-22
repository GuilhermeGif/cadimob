<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user)
    {
        return $user->profile === 'T' || $user->profile === 'S'; // Admin TI ou Admin do sistema
    }

    public function create(User $user)
    {
        return $user->profile === 'T' || $user->profile === 'S';
    }

    public function update(User $user, User $model)
    {
        if ($user->profile === 'T') {
            return true;
        } 
        if ($user->profile === 'S') {
            return $model->profile !== 'T' && $model->profile !== 'S';
        }

        return False;
    }

    public function delete(User $user)
    {
    return $user->profile === 'T';
    }

    public function accessAudit(User $user) 
    {
        return $user->profile === 'T';
    }
}
