<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;
use CodeProject\Entities\ProjectFile;

/**
 * Class ProjectTaskTransformer
 * @package namespace CodeProject\Transformers;
 */
class ProjectFileTransformer extends TransformerAbstract
{


    public function transform(ProjectFile $file)
    {
        return [
            'id' => $file->project_id,
            'idFile' => $file->id,            
            'name' => $file->name,
            'extension' => $file->extension,
            'description' => $file->description

        ];
    }
}
