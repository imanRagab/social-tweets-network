<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Responses\ErrorResponse as ResponsesErrorResponse;
use App\Helpers\UserFollowsHelper;
use App\Repository\UserRepositoryInterface;
use App\Repository\TweetRepositoryInterface;

class UserController extends BaseController  
{
    private $userRepository;
    private $tweetRepository;

    public function __construct(UserRepositoryInterface $userRepository, TweetRepositoryInterface $tweetRepository)
    {
        $this->userRepository = $userRepository;
        $this->tweetRepository = $tweetRepository;
    }

    /**
     * User follow another user.
     *
     * @param  Request  $request
     * @param  integer  $id
     * @return Response
     */
    public function follow(Request $request, $locale, $id)
    {   
        $userFollowsHelper = new UserFollowsHelper($this->userRepository);
        $followCreationCheck = $userFollowsHelper->followUser($id);
        $response = $followCreationCheck instanceof ResponsesErrorResponse ? $this->sendError($followCreationCheck->getMessages(), $followCreationCheck->getCode())
                    : $this->sendSuccess();
        return $response;
    }  

    /**
     * Get user timeline
     *
     * @return Response
     */
    public function timeline()
    {   
        $timeline = $this->tweetRepository->getUserTimeLine(Auth::id());
        return $this->sendSuccess($timeline);
    }  
}
