<?php

namespace App\Policies;

use App\User;
use App\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    
    public function reply(User $user, Comment $comment)
    {
        return !$comment->parent_id;
    }
}
