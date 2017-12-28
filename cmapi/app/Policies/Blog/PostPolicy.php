<?php

namespace App\Policies\Blog;

use App\Models\Blog\User;
use App\Models\Blog\Post;

use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update( User $user,Post $post)
    {
        return $user->id == $post->user_id;
    }
}
