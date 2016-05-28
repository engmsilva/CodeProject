<?php

namespace CodeProject\Http\Middleware;

use Closure;
use CodeProject\Http\Controllers\Auth\AuthCodeProject;

class CheckProjectPermission
{


    /**
     * @var AuthCodeProject
     */
    private $authCodeProject;

    public function __construct(AuthCodeProject $authCodeProject)
    {

        $this->authCodeProject = $authCodeProject;
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
        $project_id = $request->route('id') ? $request->route('id') : $request->route('project');

        if($this->authCodeProject->checkProjectPermissions($project_id)== false)
        {
            return ['error' => 'Access Forbidden'];
        }

        return $next($request);
    }
}
