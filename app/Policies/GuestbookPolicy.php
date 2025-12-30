<?php

namespace App\Policies;

use App\Models\Guestbook;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GuestbookPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Guestbook $guestbook): bool
    {
        return true;
        
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Guestbook $guestbook): bool
    {
        return $user->hasAnyRole(['admin', 'pst']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Guestbook $guestbook): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Guestbook $guestbook): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Guestbook $guestbook): bool
    {
        return $user->hasRole('admin');
    }

    public function accept(User $user, Guestbook $guestbook): bool
    {
        return $user->hasRole('pst');
    }
}
