<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Tweet;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Auth;

class TweetController extends BaseController  
{
    /**
     * Store a new tweet.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {   
        $data = $request->all();

        $validator = Validator::make($data, [
            'text' => 'required|string|max:140',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors(), ResponseHelper::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data['user_id'] = Auth::id();


        $tweet = Tweet::create($data);    

        return $this->sendSuccess(compact('tweet'));
    }  
    
    /**
     * Delete the given tweet.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $tweet = Tweet::find($id);
        if (!$tweet) {
            return $this->sendError(['Tweet not found'], ResponseHelper::HTTP_NOT_FOUND);
        } else if ($tweet->user_id !== Auth::id()) {
            return $this->sendError(['You are not authorized to delete this tweet'], ResponseHelper::HTTP_UNAUTHORIZED);
        }
        $tweet->delete();
        return $this->sendSuccess();
    }
}
