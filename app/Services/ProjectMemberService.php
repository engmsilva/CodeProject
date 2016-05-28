<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 07/04/2016
 * Time: 09:21
 */

namespace CodeProject\Services;


use CodeProject\Repositories\ProjectMemberRepository;
use CodeProject\Validators\ProjectMemberValidator;


class ProjectMemberService
{
    /**
     * @var ProjectMemberRepository
     */
    private $repository;
    /**
     * @var ProjectMemberValidator
     */
    private $validator;

    public function __construct(ProjectMemberRepository $repository, ProjectMemberValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function create(array $data)
    {
        try
        {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);

        }catch (\Exception $e) {
            return [
                'error' => true,
                'menssage' => $e->getMessage()
            ];
        }
    }

    public function show($id, $idMember)
    {
        try {
            return $this->repository->findWhere(['project_id'=>$id, 'member_id'=>$idMember]);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'menssage' => $e->getMessage()
            ];

        }
    }

    public function delete($idMember)
    {
        try
        {            
            $this->repository->skipPresenter()->find($idMember)->delete();
            
            return [
                'error' => false,
                'menssage' => 'Membro excluido'
            ];
        }catch (\Exception $e) {
            return [
                'error' => true,
                'menssage' => $e->getMessage()
            ];
        }
    }   

}