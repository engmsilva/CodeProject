<?php

use CodeProject\Entities\Project;
use Illuminate\Database\Seeder;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */    
    public function run()
    {

        factory(Project::class,10)->create()->each(function($project){
            $users = \CodeProject\Entities\User::all()->random(4);
            foreach ($users as $key => $value) {
                $projectMember = new \CodeProject\Entities\ProjectMember;
                $projectMember->member_id = $value->id;
                $projectMember->project_id = $project->id;
                $projectMember->save();
            }
        });

        factory(Project::class,10)->create();
    }
}
