<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 07/04/2016
 * Time: 09:21
 */

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectFileValidator;
use Illuminate\Contracts\Validation\ValidationException;
use Prettus\Validator\Exceptions\ValidatorException;
use \Prettus\Validator\Contracts\ValidatorInterface;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;


class ProjectFileService
{

    /**
     * @var ProjectFileRepository
     */
    private $repository;
    /**
     * @var ProjectFileValidator
     */
    private $validator;
    /**
     * @var ProjectRepository
     */
    private $projectRepository;
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var Storage
     */
    private $storage;

    public function __construct(
        ProjectFileRepository $repository,
        ProjectFileValidator $validator,
        ProjectRepository $projectRepository,
        Filesystem $filesystem,
        Storage $storage
    )
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->projectRepository = $projectRepository;
        $this->filesystem = $filesystem;
        $this->storage = $storage;
    }

  
    public function update(array $data, $idFile)
    {
        try {
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            return $this->repository->update($data, $idFile);

        }catch(ValidatorException $e){
            return [
                'error' => true,
                'menssage' => $e->getMessageBag()
            ];
        }
    }

    public function getFilePath($idFile)
    {
        $projectFile = $this->repository->skipPresenter()->find($idFile);

        return $this->getBaseUrl($projectFile);
    }

    private function getBaseUrl($projectFile)
    {
        switch ($this->storage->getDefaultDriver()){
            case 'local':
                return $this->storage->getDriver()->getAdapter()->getPathPrefix()
                    .'/'.$projectFile->getFileName();
        }
    }
    
    public function getFileName($idFile)    {

        $projectFile = $this->repository->skipPresenter()->find($idFile);
        return $projectFile->name.'.'.$projectFile->extension;
    }

    public function show($idFile)
    {
        try {
            return $this->repository->find($idFile);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'menssage' => $e->getMessage()
            ];

        }
    }


    public function create(array $data)
    {
        try {
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $project =$this->projectRepository->skipPresenter()->find($data['id']);

            $projectFile = $project->files()->create($data);
            $this->storage->put($projectFile->getFileName(), $this->filesystem->get($data['file']));
            return [
                'error' => false,
                'menssage' => 'O upload do arquivo '.$projectFile->getFileName().' foi feito com sucesso.'
            ];

        }catch(ValidatorException $e){
            return [
                'error' => true,
                'menssage' => $e->getMessageBag()
            ];
        }

    }

    public function delete($id, $idFile)
    {
        try {

            $projectFile = $this->repository->skipPresenter()->find($idFile);
            $this->repository->find($idFile)->delete();
            if($this->storage->exists($projectFile->getFileName()))
            {
                $this->storage->delete($projectFile->getFileName());
            }
            return [
                'error' => false,
                'menssage' => 'O arquivo '.$projectFile->getFileName().' foi deletado.'
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'menssage' => $e->getMessage()
            ];

        }
    }
}