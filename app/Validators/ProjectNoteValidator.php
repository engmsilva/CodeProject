<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 07/04/2016
 * Time: 09:58
 */

namespace CodeProject\Validators;


use Prettus\Validator\LaravelValidator;

class ProjectNoteValidator extends LaravelValidator
{
    protected $rules = [
        'project_id'=>'required|integer',
        'title' => 'required',
        'note'=> 'required'
    ];
}