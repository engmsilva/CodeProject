<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 13/04/2016
 * Time: 16:29
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\Project;

use League\Fractal\TransformerAbstract;


class ProjectTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['members'];
    public function Transform(Project $project)
    {
        return [
            'project_id' => $project->id,
            'owner' => $project->owner_id,
            'project' => $project->name,
            'description' => $project->description,
            'progress' => $project->progress,
            'status' => $project->status,
            'due_date' => $project->due_date,
        ];
    }

    public function includeMembers(Project $project)
    {
        return $this->collection($project->members, new ProjectMemberTransformer());

    }
}