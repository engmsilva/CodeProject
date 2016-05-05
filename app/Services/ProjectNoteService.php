<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 07/04/2016
 * Time: 09:21
 */

namespace CodeProject\Services;


use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Validators\ProjectNoteValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectNoteService
{

    private $repository;
    private $validator;

    /**
     * ProjectNoteService constructor.
     * @param ProjectNoteRepository $repository
     * @param ProjectNoteValidator $validator
     */
    public function __construct(ProjectNoteRepository $repository, ProjectNoteValidator $validator)
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
     * @param $noteId
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
     * @param $noteId
     * @return array|mixed
     */
    public function show($id, $noteId)
    {
        try {
            return $this->repository->findWhere(['project_id'=>$id, 'id'=>$noteId]);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'menssage' => $e->getMessage()
            ];

        }
    }

    /**
     * @param $id
     * @param $noteId
     * @return array
     */
    public function delete($id)
    {
        try {
            $noteTitle = $this->repository->skipPresenter()->find($id,['title']);
            $this->repository->find($id)->delete();
            return [
                'error' => false,
                'menssage' => 'A anotacao '.$noteTitle['title'].' foi excluida'
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'menssage' => $e->getMessage()
            ];

        }
    }
}