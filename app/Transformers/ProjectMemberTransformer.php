<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 13/04/2016
 * Time: 16:29
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectMember;

use League\Fractal\TransformerAbstract;

class ProjectMemberTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'user'
    ];

    public function Transform(ProjectMember $member)
    {
        return [
            'id' => $member->project_id,
            'idMember' => $member->id,
            'idUserMember' => $member->member_id
        ];
    }

    public function includeUser(ProjectMember $member){
        return $this->item($member->member, new UserTransformer());
    }
}