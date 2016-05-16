<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Http\Controllers\Auth\AuthCodeProject;
use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Services\ProjectFileService;
use Illuminate\Http\Request;

class ProjectFileController extends Controller
{


    /**
     * @var ProjectFileService
     */
    private $service;
    /**
     * @var AuthCodeProject
     */
    private $authCodeProject;
    /**
     * @var ProjectFileRepository
     */
    private $repository;
    /**
     * @var Request
     */
    private $request;

    public function __construct(
        ProjectFileRepository $repository,
        ProjectFileService $service,
        AuthCodeProject $authCodeProject,
        Request $request
    )
    {

        $this->service = $service;
        $this->authCodeProject = $authCodeProject;
        $this->repository = $repository;
        $this->request = $request;
    }

    public function index($id)
    {
        return $this->repository->findWhere(['project_id'=>$id]);
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
        $data['id'] = $id;
        $data['description'] = $request->description;
        
        return $this->service->create($data);
    }

    public function downloadFile($idFile)
    {
        $filePath = $this->service->getFilePath($idFile);
        $fileContent = file_get_contents($filePath);
        $file64 = base64_encode($fileContent);

        return [
            'file' => $file64,
            'size' => filesize($filePath),
            'name' => $this->service->getFileName($idFile)
        ];
    }

    public function show($id, $idFile)
    {
        if($this->authCodeProject->checkProjectPermissions($id)==false) {
            return ['erro' => 'Access Forbidden'];
        }
        return $this->service->show($idFile);
    }

    public function update($id, $idFile)
    {
        if($this->authCodeProject->checkProjectPermissions($id)==false) {
            return ['erro' => 'Access Forbidden'];
        }
        
        return $this->service->update($this->request->all(), $idFile);
    }


    public function destroy($id, $idFile)
    {
        if($this->authCodeProject->checkProjectPermissions($id)==false) {
            return ['erro' => 'Access Forbidden'];
        }
        return $this->service->delete($id, $idFile);
    }

}
