<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 14/04/2016
 * Time: 21:01
 */

namespace CodeProject\Repositories;


use CodeProject\Entities\ProjectFile;
use CodeProject\Presenters\ProjectFilePresenter;
use Prettus\Repository\Eloquent\BaseRepository;


class ProjectFileRepositoryEloquent extends BaseRepository implements ProjectFileRepository
{
    public function model()
    {
        // TODO: Implement model() method.
        return ProjectFile::class;
    }

    public function presenter()
    {
        return ProjectFilePresenter::class;
    }

}