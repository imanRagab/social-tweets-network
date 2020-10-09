<?php

namespace App\Repository;


use Illuminate\Database\Eloquent\Model;

/**
* Interface TweetRepositoryInterface
*/
interface TweetRepositoryInterface
{
   /**
    * @param $id
    * @return Model
    */
   public function find($id): ?Model;
}