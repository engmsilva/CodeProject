<?php

namespace CodeProject\Http\Middleware;

use Closure;
use CodeProject\Repositories\ProjectRepository;
use LucaDegasperi\OAuth2Server\Authorizer;

class CheckProjectOwner
{

    /**
     * @var Authorizer
     */
    private $authorizer;
    /**
     * @var ProjectRepository
     */
    private $repository;

    public function __construct(ProjectRepository $repository, Authorizer $authorizer)
    {
        $this->authorizer = $authorizer;

        $this->repository = $repository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userId =  $this->authorizer->getResourceOwnerId();
        $projectId = $request->project;

        if($this->repository->isOwner($projectId, $userId) == false)
        {
            return response([
                'error' => true,
                'menssage' => 'Suas credenciais não permite acessar esse projeto'
            ]);
        }

        return $next($request);
    }
}
