<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Authorizer;
use CodeProject\Http\Controllers\Auth\AuthCodeProject;


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
     * @var AuthCodeProject
     */
    private $authCodeProject;

    public function __construct(
        ProjectRepository $repository,
        ProjectService $service,
        Authorizer $authorizer,
        AuthCodeProject $authCodeProject
        )
    {
        $this->repository = $repository;
        $this->service = $service;
        $this->authorizer = $authorizer;
        $this->authCodeProject = $authCodeProject;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $userId = $this->authorizer->getResourceOwnerId();
         return $this->repository->isOwnerMember($userId)->all();

       //return $this->repository->skipPresenter()->with(['owner', 'client'])->findWhere(['owner_id' => $this->authorizer->getResourceOwnerId()]);
    }

    public function members($id)
    {
        if($this->authCodeProject->checkProjectPermissions($id)==false) {
            return ['erro' => 'Access Forbidden'];
        }
        $project = $this->repository->skipPresenter()->find($id);
        return $project->members;
    }

    public function addMember($id, $idUser)
    {
        if($this->authCodeProject->checkProjectOwner($id)==false) {
            return ['erro' => 'Access Forbidden'];
        }
        return $this->service->addMember(['project_id'=>$id,'member_id' => $idUser]);
    }

    public function removeMember($id, $idUser)
    {
        if($this->authCodeProject->checkProjectOwner($id)==false) {
            return ['erro' => 'Access Forbidden'];
        }
        return $this->service->removeMember($idUser);
    }
    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $userId = $this->authorizer->getResourceOwnerId();
        $request['owner_id'] = $userId;
        return $this->service->create($request->all());
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        if($this->authCodeProject->checkProjectOwner($id)==false) {
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
       if($this->authCodeProject->checkProjectPermissions($id)==false) {
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
        if($this->authCodeProject->checkProjectOwner($id)==false) {
            return ['erro' => 'Access Forbidden'];
        }
        return $this->service->delete($id);
    }

}
