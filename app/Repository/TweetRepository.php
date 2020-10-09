<?php   

namespace App\Repository;

use App\Repository\Interfaces\TweetRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use App\Tweet;

class TweetRepository implements TweetRepositoryInterface
{    
    /**
    * @param $id
    * @return Model
    */
    public function find($id): ?Model
    {
        return Tweet::find($id);
    }

    public function getUserTimeLine($user)
    {
        return Tweet::whereIn('user_id', function($query) use ($user) {
                    $query->select('user_id')
                            ->from('follows')
                            ->where('follows.follower_id', $user);
            })->orderBy('updated_at','desc')->paginate(10);
    }

}