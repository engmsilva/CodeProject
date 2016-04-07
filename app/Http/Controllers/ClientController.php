<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ClientRepository;
use Illuminate\Http\Request;


class ClientController extends Controller
{
    /**
     * @var ClientRepository
     */
    private $repository;

    /**
     * ClientController constructor.
     * @param ClientRepository $repository
     */
    public function __construct(ClientRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function index()
    {
       return $this->repository->all();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->repository->create($request->all());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->repository->find($id)->delete();
    }
}
