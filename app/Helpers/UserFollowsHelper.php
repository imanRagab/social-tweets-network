<?php

namespace App\Helpers;

use App\Follow;
use App\Helpers\Responses\ErrorResponse;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UserFollowsHelper
{

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    private function checkCanFollow($id)
    {
        $user = $this->userRepository->find($id);

        $isAlreadyFollowing = $this->userRepository->isUserFollowing(Auth::id(), $id);

        if (!$user) {
            return new ErrorResponse(ResponseHelper::HTTP_NOT_FOUND, [__('User not found')]);

        } else if ($id == Auth::id()) {
            return new ErrorResponse(ResponseHelper::HTTP_UNAUTHORIZED, [__('You can not follow yourself')]);

        } else if ($isAlreadyFollowing) {
            return new ErrorResponse(ResponseHelper::HTTP_UNAUTHORIZED, [__('You are already following this user')]);
        } else {
            return true;
        }
    }

    public function followUser($id)
    {
        $checkUserCanFollow = $this->checkCanFollow($id);

        if($checkUserCanFollow instanceof ErrorResponse) {
            return $checkUserCanFollow;
        }

        $data['user_id'] = $id;
        $data['follower_id'] = Auth::id();
        Follow::create($data); 

        return true;
    }


}
