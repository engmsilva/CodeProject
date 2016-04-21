<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;
use CodeProject\Entities\ProjectTask;

/**
 * Class ProjectTaskTransformer
 * @package namespace CodeProject\Transformers;
 */
class ProjectTaskTransformer extends TransformerAbstract
{


    public function transform(ProjectTask $task)
    {
        return [
            'id' => $task->id,
            'name' => $task->name,
            'project_id' => $task->project_id,
            'start_date' => $task->start_date,
            'due_date' => $task->due_date,
            'status' => $task->status,
        ];
    }
}
