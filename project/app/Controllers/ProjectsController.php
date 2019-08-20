<?php

namespace App\Controllers;

class ProjectsController
{
    public function getAddProjectAction ( $request ) {
        if ( $request->getMethod() == 'POST' ) {
            $postData = $request->getParsedBody();
            $project = new \App\Models\Project();
            $project->title = $postData['title'];
            $project->description = $postData['description'];
            $project->save();
        }

        include '../views/addProject.php';
    }
}