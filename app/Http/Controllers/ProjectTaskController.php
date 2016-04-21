<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Http\Controllers\Auth\AuthCodeProject;
use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Services\ProjectTaskService;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;

class ProjectTaskController extends Controller
{
    /**
     * @var ProjectTaskRepository
     */
    private $repository;
    /**
     * @var ProjectTaskService
     */
    private $service;
    /**
     * @var AuthCodeProject
     */
    private $authCodeProject;

    public function __construct(ProjectTaskRepository $repository, ProjectTaskService $service, AuthCodeProject $authCodeProject)
    {

        $this->repository = $repository;
        $this->service = $service;
        $this->authCodeProject = $authCodeProject;
    }

    public function index($id)
    {
        if($this->authCodeProject->checkProjectPermissions($id)==false) {
            return ['erro' => 'Access Forbidden'];
        }
        return $this->repository->findWhere(['project_id'=>$id]);
    }

    public function store(Request $request)
    {
        $request['project_id'] = $request->id;

        if($this->authCodeProject->checkProjectPermissions($request['project_id'])==false) {
            return ['erro' => 'Access Forbidden'];
        }
        return $this->service->create($request->all());
    }

    public function update(Request $request, $id, $idTask)
    {
        $request['project_id'] = $id;
        if($this->authCodeProject->checkProjectPermissions($id)==false) {
            return ['erro' => 'Access Forbidden'];
        }
        return $this->service->update($request->all(), $idTask);
    }

    public function show($id, $taskId)
    {
        if($this->authCodeProject->checkProjectPermissions($id)==false) {
            return ['erro' => 'Access Forbidden'];
        }
        return $this->service->show($id, $taskId);
    }
    public function destroy($id, $idTask)    {

        if($this->authCodeProject->checkProjectPermissions($id)==false) {
            return ['erro' => 'Access Forbidden'];
        }
        return $this->service->delete($idTask);
    }
}
