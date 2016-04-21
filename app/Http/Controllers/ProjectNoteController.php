<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Http\Controllers\Auth\AuthCodeProject;
use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Services\ProjectNoteService;
use Illuminate\Http\Request;


class ProjectNoteController extends Controller
{

    private $repository;
    private $service;
    /**
     * @var AuthCodeProject
     */
    private $authCodeProject;

    /**
     * ProjectNoteController constructor.
     * @param ProjectNoteRepository $repository
     * @param ProjectNoteService $service
     */
    public function __construct(ProjectNoteRepository $repository,
                                ProjectNoteService $service,
                                AuthCodeProject $authCodeProject)
    {
        $this->repository = $repository;
        $this->service = $service;
        $this->authCodeProject = $authCodeProject;
    }

    /**
     * @return mixed
     */
    public function index($id)
    {
        if($this->authCodeProject->checkProjectPermissions($id)==false) {
            return ['erro' => 'Access Forbidden'];
        }
        return $this->repository->findWhere(['project_id'=>$id]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $request['project_id'] = $request->id;

        if($this->authCodeProject->checkProjectPermissions($request['project_id'])==false) {
            return ['erro' => 'Access Forbidden'];
        }
        return $this->service->create($request->all());
    }

    /**
     * @param Request $request
     * @param $id
     * @param $noteId
     * @return mixed
     * @internal param $id
     */
    public function update(Request $request, $id, $idNote)
    {
        $request['project_id'] = $id;
        if($this->authCodeProject->checkProjectPermissions($id)==false) {
            return ['erro' => 'Access Forbidden'];
        }
        return $this->service->update($request->all(), $idNote);
    }

    /**
     * @param $id
     * @param $noteId
     * @return mixed
     */
    public function show($id, $noteId)
    {
        if($this->authCodeProject->checkProjectPermissions($id)==false) {
            return ['erro' => 'Access Forbidden'];
        }
        return $this->service->show($id, $noteId);
    }

    /**
     * @param $id
     * @param $noteId
     * @return mixed
     */
    public function destroy($id, $idNote)    {

        if($this->authCodeProject->checkProjectPermissions($id)==false) {
            return ['erro' => 'Access Forbidden'];
        }
        return $this->service->delete($idNote);
    }
}
