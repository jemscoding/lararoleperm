<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can view any models
     */
    public function viewAny(User $user, Post $post): bool
    {
        //check if user has a role of admin and super admin
        if ($user->hasAnyRole(['admin','super_admin']))
        {
            return true;
        }

        //check if user has a role of editor and permission that can view posts
        if ($user->hasRole('editor') && $user->can('view posts')) //role and permission
        {
            return true;
        }

        //check if user has a role of author and the user id is equal to the post id
        if ($user->hasRole('author') && $user->id == $post->user_id)
        {
            return true;
        }

        // if all if statements are false, the user views all posts or default permission
        return $user->can('view posts');


    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post): bool
    {
        if($user->hasAnyRole(['admin','super_admin','editor']))
        {
        return true;
        }

        return $user->can('view posts');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user->hasAnyRole(['admin','super_admin','editor']))
        {
        return true;
        }

        return $user->can('create posts');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
         return $user->hasRole('admin') ? true : false;

         if($user->hasRole('editor') && $user->can('update posts'))
         {
            return true;
         }

         if($user->hasRole('author') && $user->id == $post->user_id)
         {
            return true;
         }

         return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        //check if user has a role of admin and super admin
        if ($user->hasAnyRole(['admin','super_admin']))
        {
            return true;
        }

        //check if user has a role of editor and permission that can delete posts
        if ($user->hasRole('editor') && $user->can('delete posts')) //role and permission
        {
            return true;
        }
        
        // return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        //check if user has a role of admin and super admin
        if ($user->hasAnyRole(['admin','super_admin']))
        {
            return true;
        }

        //check if user has a role of editor and permission that can restore posts
        if ($user->hasRole('editor') && $user->can('restore posts')) //role and permission
        {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        //check if user has a role of admin and super admin
        if ($user->hasAnyRole(['admin','super_admin']))
        {
            return true;
        }

        //check if user has a role of editor and permission that can force delete posts
        if ($user->hasRole('editor') && $user->can('force delete posts')) //role and permission
        {
            return true;
        }

        return false;
    }

    public function publish(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'manager', 'editor']);
    }
}
