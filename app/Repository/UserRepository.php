<?php   

namespace App\Repository;

use App\Repository\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\User;

class UserRepository implements UserRepositoryInterface
{    
    /**
    * @param $id
    * @return Model
    */
    public function find($id): ?Model
    {
        return User::find($id);
    }

    /**
    * @param integer $user
    * @param integer $followedUser
    * @return boolean
    */
    public function isUserFollowing($user, $followedUser)
    {
        return User::where('id', $user)
                    ->whereHas('followsInWhichIsFollower', function (Builder $query) use ($followedUser) {
                        $query->where('user_id', $followedUser);
                    })
                    ->exists();
    }
}