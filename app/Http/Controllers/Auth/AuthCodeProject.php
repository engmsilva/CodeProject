<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 19/04/2016
 * Time: 18:09
 */

namespace CodeProject\Http\Controllers\Auth;


use CodeProject\Repositories\ProjectRepository;
use LucaDegasperi\OAuth2Server\Authorizer;

class AuthCodeProject
{

    /**
     * @var ProjectRepository
     */
    private $repository;
    /**
     * @var Authorizer
     */
    private $authorizer;

    public function __construct(ProjectRepository $repository, Authorizer $authorizer)
   {
       $this->repository = $repository;
       $this->authorizer = $authorizer;
   }

    public function checkProjectOwner($projectId)
    {
        $userId =  $this->authorizer->getResourceOwnerId();
        if(count($this->repository->skipPresenter()->findWhere(['id' => $projectId, 'owner_id' => $userId])))
        {
            return true;
        }

        return false;
    }

    public function checkProjectMember($projectId)
    {
        $memberId =  $this->authorizer->getResourceOwnerId();
        $project = $this->repository->skipPresenter()->find($projectId);

        foreach($project->members as $member)
        {
            if($member->id == $memberId)
            {
                return true;
            }
        }

        return false;
    }

    public function checkProjectPermissions($projectId)
    {
        if($this->checkProjectOwner($projectId) or $this->checkProjectMember($projectId))
        {
            return true;
        }

        return false;
    }

}