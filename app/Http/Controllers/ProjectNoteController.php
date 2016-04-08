<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Services\ProjectNoteService;
use Illuminate\Http\Request;


class ProjectNoteController extends Controller
{

    private $repository;

    private $service;


    /**
     * ProjectNoteController constructor.
     * @param ProjectNoteRepository $repository
     * @param ProjectNoteService $service
     */
    public function __construct(ProjectNoteRepository $repository, ProjectNoteService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function index($id)
    {
       return $this->repository->findWhere(['project_id'=>$id]);
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
     * @param $noteId
     * @return mixed
     * @internal param $id
     */
    public function update(Request $request, $id)
    {

        return $this->service->update($request->all(), $id);
    }

    /**
     * @param $id
     * @param $noteId
     * @return mixed
     */
    public function show($id, $noteId)
    {
        return $this->service->show($id, $noteId);
    }

    /**
     * @param $id
     * @param $noteId
     * @return mixed
     */
    public function destroy($id)    {

        return $this->service->delete($id);
    }
}
