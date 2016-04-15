<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 14/04/2016
 * Time: 21:01
 */

namespace CodeProject\Repositories;


use CodeProject\Entities\ProjectTask;
use Prettus\Repository\Eloquent\BaseRepository;

class ProjectTaskRepositoryEloquent extends BaseRepository implements ProjectTaskRepository
{
    public function model()
    {
        // TODO: Implement model() method.
        return ProjectTask::class;
    }
}