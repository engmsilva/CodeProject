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

    /**
     * ProjectTaskController constructor.
     * @param ProjectTaskRepository $repository
     * @param ProjectTaskService $service
     */
    public function __construct(ProjectTaskRepository $repository, ProjectTaskService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function index($id)
    {
        return $this->repository->findWhere(['project_id'=>$id]);
    }

    /**
     * @param Request $request
     * @return array|mixed
     */
    public function store(Request $request)
    {

        $request['project_id'] = $request->id;        
        
        return $this->service->create($request->all());
    }

    /**
     * @param Request $request
     * @param $id
     * @param $idTask
     * @return array|mixed
     */
    public function update(Request $request, $id, $idTask)
    {
        return $this->service->update($request->all(), $idTask);
    }

    /**
     * @param $id
     * @param $idTask
     * @return array|mixed
     */
    public function show($id, $idTask)
    {
        $result = $this->service->show($id, $idTask);
        if(isset($result['data']) && count($result['data'])==1){
            $result = [
                'data' => $result['data'][0]
            ];
        }
        return $result;
    }

    /**
     * @param $id
     * @param $idTask
     * @return array
     */
    public function destroy($id, $idTask)
    {
        return $this->service->delete($idTask);
    }
}
