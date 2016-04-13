<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Entities\User;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Authorizer;


class ProjectController extends Controller
{


    /**
     * @var Authorizer
     */
    private $authorizer;
    /**
     * @var ProjectRepository
     */
    private $repository;
    /**
     * @var ProjectService
     */
    private $service;

    /**
     * ProjectController constructor.
     * @param ProjectRepository $repository
     * @param ProjectService $service
     * @param Authorizer $authorizer
     */
    public function __construct(
        ProjectRepository $repository,
        ProjectService $service,
        Authorizer $authorizer
        )
    {
        $this->repository = $repository;
        $this->service = $service;
        $this->authorizer = $authorizer;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $userId = $this->authorizer->getResourceOwnerId();
        $member = User::find($userId);

        //return $member->projects;

        return $this->repository->with(['owner', 'client'])->findWhere(['owner_id' => $this->authorizer->getResourceOwnerId()]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {

        return $this->service->create($request->all());
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        if($this->checkProjectOwner($id)==false) {
            return ['erro' => 'Access Forbidden'];
        }
        return $this->service->update($request->all(), $id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
       if($this->checkProjectPermissions($id)==false) {
           return ['erro' => 'Access Forbidden'];
       }
        return $this->service->show($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        if($this->checkProjectOwner($id)==false) {
            return ['erro' => 'Access Forbidden'];
        }
        return $this->service->delete($id);
    }

    private function checkProjectOwner($projectId)
    {
        $userId =  $this->authorizer->getResourceOwnerId();
        return $this->repository->isOwner($projectId, $userId);
    }

    private function checkProjectMember($projectId)
    {
        $userId =  $this->authorizer->getResourceOwnerId();
        return $this->repository->hasMember($projectId, $userId);
    }

    private function checkProjectPermissions($projectId)
    {
        if($this->checkProjectOwner($projectId) or $this->checkProjectMember($projectId))
        {
            return true;
        }

        return false;
    }
}
