<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class AdminPolicy
{
   
    // To identfy a role 
    public function admin(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can access admin dashboard.
     */
    public function accessAdminPanel(User $user): bool
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        // Admins can view any user, users can only view themselves
        return $user->is_admin || $user->id === $model->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // Admins can update any user, users can only update themselves
        return $user->is_admin || $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // Prevent users from deleting themselves
        return $user->is_admin && $user->id !== $model->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->is_admin && $user->id !== $model->id;
    }

    /**
     * Determine whether the user can manage application settings.
     */
    public function manageSettings(User $user): bool
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can impersonate other users.
     */
    public function impersonate(User $user): bool
    {
        return $user->is_admin;
    }
    
}
