<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 13/04/2016
 * Time: 16:29
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\User;

use League\Fractal\TransformerAbstract;

class ProjectMemberTransformer extends TransformerAbstract
{
   protected $defaultIncludes = ['user'];

    public function Transform(User $member)
    {
        return [
            'member_id' => $member->id,
            'name' => $member->name,

        ];
    }

    public function includeUser(User $member)
    {
        return $this->item($member, new UserTransformer());

    }
}