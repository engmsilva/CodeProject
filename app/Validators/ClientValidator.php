<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 07/04/2016
 * Time: 09:58
 */

namespace CodeProject\Validators;


use Prettus\Validator\LaravelValidator;

class ClientValidator extends LaravelValidator
{
    protected $rules = [
        'name'=> 'required|max:255',
        'responsible' => 'required|max:255',
        'email' => 'required',
        'phone' => 'required',
        'address' => 'required'
    ];
}