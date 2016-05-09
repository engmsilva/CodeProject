<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 13/04/2016
 * Time: 16:29
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\Project;
use CodeProject\Entities\Client;

use League\Fractal\TransformerAbstract;



class ProjectTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['members','client'];
    
    public function Transform(Project $project)
    {
        return [
            'id' => $project->id,
            'owner' => $project->owner_id,
            'client_id' => $project->client_id,
            'name' => $project->name,
            'description' => $project->description,
            'progress' => (int) $project->progress,
            'status' => $project->status,
            'due_date' => $project->due_date,
        ];
    }

    public function includeMembers(Project $project)
    {
        return $this->collection($project->members, new ProjectMemberTransformer());

    }

    public function includeClient(Project $project)
    {
        return $this->item($project->client, new ClientTransformer());

    }

    public function includeNotes(Project $project)
    {
        return $this->collection($project->notes, new ProjectNoteTransformer());

    }

    public function includeTasks(Project $project)
    {
        return $this->collection($project->tasks, new ProjectTaskTransformer());

    }

}