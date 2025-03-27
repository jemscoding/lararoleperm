<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Category;

class CategoryPolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Category $category): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'manager', 'editor', 'author', 'contributor']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Category $category): bool
    {
         // Admin and manager can edit all posts
         if ($user->hasAnyRole(['admin', 'manager', 'editor'])) {
            return true;
        }

        // Author can edit their own posts
        return $user->hasRole('author') && $user->id === $category->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Category $category): bool
    {
        // Admin and manager can delete all posts
        if ($user->hasAnyRole(['admin', 'manager'])) {
            return true;
        }

        // Author can delete their own posts
        return $user->hasRole('author') && $user->id === $category->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Category $category): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Category $category): bool
    {
        return false;
    }

}
