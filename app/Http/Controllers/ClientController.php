<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Client;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;

class ClientController extends Controller
{
    public function index()
    {
        return \CodeProject\Client::all();
    }

    public function store(Request $request)
    {
        return Client::create($request->all());
    }
}
