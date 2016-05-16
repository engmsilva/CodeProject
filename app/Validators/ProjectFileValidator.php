<?php

namespace CodeProject\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class ProjectFileValidator extends LaravelValidator {

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'id' => 'required',
            'name' => 'required',
            'file' => 'required|mimes:jpeg,png,gif,pdf,zip,rar',
            'description' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'id' => 'required',
            'name' => 'required',
            'description' => 'required'
        ]
   ];

}