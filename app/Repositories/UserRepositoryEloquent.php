<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 05/04/2016
 * Time: 23:27
 */

namespace CodeProject\Repositories;


use CodeProject\Entities\User;
use Prettus\Repository\Eloquent\BaseRepository;


class UserRepositoryEloquent extends BaseRepository implements UserRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

  
}