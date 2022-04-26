<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\DB;

class CUDPolicy
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

    public function updateDelete(User $user, $model)
    {
        return $user->role === 'admin' || $user->id === ($model->user_id??$model->id);
    }

    public function createComment(User $user, $product): bool
    {
        return DB::table('comments')->where([['user_id', $user->id], ['product_id', $product->id]])->doesntExist()
            && $user->id != $product->user->id;
    }
}
