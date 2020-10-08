<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use App\Http\Requests\RegisterUser;

class RegisterController extends BaseController  
{
    public function register(RegisterUser $request)
    {   
        $data = $request->all();
        $user = User::create($data);    
        return $this->sendSuccess(compact('user'));
    }    
}
