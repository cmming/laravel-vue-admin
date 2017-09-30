<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserOriFiles;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserOriResPolicy
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
	//修改资源的权限
	public function update(User $user,UserOriFiles $userOriFiles){
		return $user->uid === $userOriFiles->author_id;
	}
	//删除资源的权限
	public function delete(User $user,UserOriFiles $userOriFiles){
		return $user->uid === $userOriFiles->author_id;
	}
}
