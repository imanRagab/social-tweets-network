<?php

namespace App\Repository\Interfaces;


use Illuminate\Database\Eloquent\Model;

/**
* Interface UserRepositoryInterface
*/
interface UserRepositoryInterface
{
   /**
    * @param $id
    * @return Model
    */
   public function find($id): ?Model;
}