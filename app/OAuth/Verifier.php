<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 08/04/2016
 * Time: 20:57
 */

namespace CodeProject\OAuth;


use Illuminate\Support\Facades\Auth;

class Verifier
{
    /**
     * @param $username
     * @param $password
     * @return bool
     */
    public function verify($username, $password)
    {
        $credentials = [
            'email'    => $username,
            'password' => $password,
        ];

        if (Auth::once($credentials)) {
            return Auth::user()->id;
        }

        return false;
    }
}