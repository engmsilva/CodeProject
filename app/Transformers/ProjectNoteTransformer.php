<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectNote;
use League\Fractal\TransformerAbstract;

/**
 * Class ProjectTaskTransformer
 * @package namespace CodeProject\Transformers;
 */
class ProjectNoteTransformer extends TransformerAbstract
{


    public function transform(ProjectNote $note)
    {
        return [
            'id' => $note->project_id,
            'idNote' => $note->id,            
            'title' => $note->title,
            'note' => $note->note
        ];
    }
}
