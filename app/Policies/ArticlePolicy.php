<?php

namespace App\Policies;

use App\Models\Articles;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
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

    public function update(User $currentUser, Articles $articles){
        return $currentUser->id === $articles->user_id;
    }

    public function delete(User $currentUser, Articles $articles){
        return $currentUser->id === $articles->user_id || $currentUser->is_admin === 1;
    }
}
