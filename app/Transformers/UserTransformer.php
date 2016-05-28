<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 13/04/2016
 * Time: 16:29
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\User;

use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function Transform(User $user)
    {
        return [
            'idUser' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];
    }
}