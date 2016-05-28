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
     * @param $idNote
     * @return array|mixed
     */
    public function update(array $data, $idNote)
    {

        try {

        try {

            $this->validator->with($data)->passesOrFail();

            return $this->repository->update($data, $idNote);

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
    public function show($id, $idNote)
    {
        try {
            return $this->repository->findWhere(['project_id'=>$id, 'id'=>$idNote]);
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
    public function delete($idNote)
    {
        try {
            $noteTitle = $this->repository->skipPresenter()->find($idNote,['title']);
            $this->repository->find($idNote)->delete();
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