<?php

namespace App\Controllers;

class ProjectsController extends BaseController
{
    public function getAddProjectAction ( $request ) {
        if ( $request->getMethod() == 'POST' ) {
            $postData = $request->getParsedBody();
            $project = new \App\Models\Project();
            $project->title = $postData['title'];
            $project->description = $postData['description'];
            $project->save();
        }

        return $this->renderHTML('addProject.twig');
    }
}