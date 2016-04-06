<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Entities\Client;
use CodeProject\Repositories\ClientRepositoryEloquent;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;

class ClientController extends Controller
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index(ClientRepositoryEloquent $repository)
    {
        return $repository->all();
    }

    /**
     * @param Request $request
     * @return static
     */
    public function store(Request $request)
    {
        return Client::create($request->all());
    }

    public function show($id)
    {
        return Client::find($id);
    }

    public function destroy($id)
    {
        return Client::find($id)->delete();
    }
}
