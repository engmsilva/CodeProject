<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 07/04/2016
 * Time: 09:21
 */

namespace CodeProject\Services;


use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectService
{

    private $repository;
    private $validator;

    /**
     * ClientService constructor.
     * @param ProjectRepository $repository
     * @param ProjectValidator $validator
     */
    public function __construct(ProjectRepository $repository, ProjectValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * @param array $data
     * @return array|mixed
     */
    public function create(array $data)
    {
        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        } catch (ValidatorException $e) {
            return [
                'error' => true,
                'menssage' => $e->getMessageBag()
            ];

        }
    }

    /**
     * @param array $data
     * @param $id
     * @return array|mixed
     */
    public function update(array $data, $id)
    {
        try {

        try {

            $this->validator->with($data)->passesOrFail();
            return $this->repository->update($data, $id);

        } catch (ValidatorException $e) {

            return [
                'error' => true,
                'menssage' => $e->getMessageBag()
            ];
        }
        }catch (\Exception $e){
            return [
                'error' => true,
                'menssage' => $e->getMessage()
            ];
        }
    }
    /**
     * @param $id
     * @return array|mixed
     */
    public function show($id)
    {
        try {
            return $this->repository->find($id);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'menssage' => $e->getMessage()
            ];

        }
    }

    /**
     * @return mixed
     */
    public function ownerClientAll()
    {
        return $this->repository->with(['owner', 'client'])->all();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function ownerClientShow($id)
    {

        return $this->repository->with(['owner', 'client'])->find($id);
    }

    /**
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        try {
            $clientName = $this->repository->find($id,['name']);
            $this->repository->find($id)->delete();
            return [
                'error' => false,
                'menssage' => 'O projeto '.$clientName['name'].' foi excluido'
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'menssage' => $e->getMessage()
            ];

        }
    }
}