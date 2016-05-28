<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Http\Controllers\Auth\AuthCodeProject;
use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Services\ProjectNoteService;
use Illuminate\Http\Request;


class ProjectNoteController extends Controller
{


    /**
     * @var ProjectNoteRepository
     */
    private $repository;
    /**
     * @var ProjectNoteService
     */
    private $service;

    /**
     * ProjectNoteController constructor.
     * @param ProjectNoteRepository $repository
     * @param ProjectNoteService $service
     */
    public function __construct(ProjectNoteRepository $repository,
                                ProjectNoteService $service)
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
        return  $this->repository->findWhere(['project_id'=>$id]);
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

    public function update(Request $request, $id, $idNote)
    {
        return $this->service->update($request->all(), $idNote);
    }


    /**
     * @param $id
     * @param $idNote
     * @return array|mixed
     */
    public function show($id, $idNote)
    {        
       $result = $this->service->show($id, $idNote);
        if(isset($result['data']) && count($result['data'])==1){
            $result = [
                'data' => $result['data'][0]
            ];
        }
        return $result;
    }


    /**
     * @param $id
     * @param $idNote
     * @return array
     */
    public function destroy($id, $idNote)    
    {        
        return $this->service->delete($idNote);
    }
}
