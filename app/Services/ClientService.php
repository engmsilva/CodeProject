<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 07/04/2016
 * Time: 09:21
 */

namespace CodeProject\Services;


use CodeProject\Repositories\ClientRepository;
use CodeProject\Validators\ClientValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class ClientService
{
    /**
     * @var ClientRepository
     */
    private $repository;
    /**
     * @var ClientValidator
     */
    private $validator;

    /**
     * ClientService constructor.
     * @param ClientRepository $repository
     */
    public function __construct(ClientRepository $repository, ClientValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * @param array $data
     * @return mixed
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
     * @return mixed
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


    public function delete($id)
    {
        try {
            $clientName = $this->repository->skipPresenter()->find($id,['name']);
            $this->repository->find($id)->delete();
            return [
                'error' => false,
                'menssage' => 'O cliente '.$clientName['name'].' foi excluido'
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'menssage' => $e->getMessage()
            ];

        }
    }
}