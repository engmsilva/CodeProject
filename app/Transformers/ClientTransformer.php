<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;
use CodeProject\Entities\Client;

/**
 * Class ProjectTaskTransformer
 * @package namespace CodeProject\Transformers;
 */
class ClientTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['projects'];

    public function transform(Client $client)
    {
        return [

            'idClient' => $client->id,
            'name' => $client->name,
            'responsible' => $client->responsible,
            'email' => $client->email,
            'phone' => $client->phone,
            'address' => $client->address,
            'obs' => $client->obs,
        ];
    }

    public function includeProjects(Client $client)
    {
        $transformer = new ProjectTransformer();
        $transformer->setDefaultIncludes([]);

        return $this->collection($client->projects, $transformer);

    }
}
