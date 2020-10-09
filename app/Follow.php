<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
        'follower_id', 'user_id'
    ];

    /**
     * Get the user that the follower follows.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Get the follower.
     */
    public function follower()
    {
        return $this->belongsTo('App\User', 'follower_id');
    }
}
