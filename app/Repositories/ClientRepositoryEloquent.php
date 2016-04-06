<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 05/04/2016
 * Time: 23:27
 */

namespace CodeProject\Repositories;


use CodeProject\Entities\Client;
use Prettus\Repository\Eloquent\BaseRepository;

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Client::class;
    }
}