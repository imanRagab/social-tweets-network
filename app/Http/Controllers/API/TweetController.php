<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Tweet;
use App\Http\Requests\StoreTweet;
use Illuminate\Support\Facades\Auth;

class TweetController extends BaseController  
{
    /**
     * Store a new tweet.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(StoreTweet $request)
    {   
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $tweet = Tweet::create($data);    
        return $this->sendSuccess(compact('tweet'));
    }  
    

}
