<?php

namespace CodeProject\Http\Controllers;



use CodeProject\Repositories\ProjectMemberRepository;
use CodeProject\Services\ProjectMemberService;

class ProjectMemberController extends Controller
{

    /**
     * @var ProjectMemberService
     */
    private $service;
    /**
     * @var ProjectMemberRepository
     */
    private $repository;

    public function __construct(ProjectMemberRepository $repository, ProjectMemberService $service)
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->middleware('check-project-owner', ['except' => ['index','show']]);
        $this->middleware('check-project-permission', ['except' => ['store','destroy']]);
    }    

    public function index($id)
    {
        return  $this->repository->findWhere(['project_id'=>$id]);
    }

    public function store($id, $idMember)
    {
        return $this->service->create(['project_id'=>$id,'member_id' => $idMember]);
    }

    public function show($id, $idMember)
    {

        $result = $this->service->show($id, $idMember);
        if(isset($result['data']) && count($result['data'])==1){
            $result = [
                'data' => $result['data'][0]
            ];
        }
        return $result;
       
    }

    public function destroy($id, $idMember)
    {
        return $this->service->delete($idMember);
    }

}
