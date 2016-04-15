<?php

namespace CodeProject\Http\Controllers;

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

    public function __construct(ProjectTaskRepository $repository, ProjectTaskService $service)
    {

        $this->repository = $repository;
        $this->service = $service;
    }

    public function index($id)
    {
        return $this->repository->findWhere(['project_id'=>$id]);
    }

    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }

    public function update(Request $request, $id)
    {
        return $this->service->update($request->all(), $id);
    }

    public function show($id, $taskId)
    {
        return $this->service->show($id, $taskId);
    }
    public function destroy($id)    {

        return $this->service->delete($id);
    }
}
