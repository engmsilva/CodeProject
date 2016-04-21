<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 07/04/2016
 * Time: 09:58
 */

namespace CodeProject\Validators;


use Prettus\Validator\LaravelValidator;

class ProjectValidator extends LaravelValidator
{
    protected $rules = [
        'client_id' => 'required|integer',
        'name'=> 'required',
        'progress' => 'required',
        'status' => 'required',
        'due_date' => 'required'
    ];
}