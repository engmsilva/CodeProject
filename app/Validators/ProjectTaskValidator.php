<?php

namespace CodeProject\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class ProjectTaskValidator extends LaravelValidator {

    protected $rules = [
        'name'=> 'required'
   ];

}