<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Http\Controllers\Auth\AuthCodeProject;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Authorizer;

class ProjectFileController extends Controller
{

    /**
     * @var ProjectService
     */
    private $service;
    /**
     * @var AuthCodeProject
     */
    private $authCodeProject;


    public function __construct(ProjectService $service, AuthCodeProject $authCodeProject)
    {
        $this->service = $service;

        $this->authCodeProject = $authCodeProject;
    }

    public function index()
    {

    }

    public function store(Request $request)
    {
        $id = $request->id;

        if($this->authCodeProject->checkProjectPermissions($id)==false) {
            return ['erro' => 'Access Forbidden'];
        }
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        $data['file'] = $file;
        $data['extension'] = $extension;
        $data['name'] = $request->name;
        $data['project_id'] = $id;
        $data['description'] = $request->description;

        return $this->service->createFile($data);
    }

    public function show($id)
    {

    }


    public function destroy($id, $idFile)
    {
        if($this->authCodeProject->checkProjectPermissions($id)==false) {
            return ['erro' => 'Access Forbidden'];
        }
        return $this->service->deleteFile($id, $idFile);
    }

}
