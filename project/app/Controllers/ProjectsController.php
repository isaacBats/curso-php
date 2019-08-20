<?php

namespace App\Controllers;

class ProjectsController
{
    public function getAddProjectAction () {
        if ( !empty($_POST) ) {
            $project = new App\Models\Project();
            $project->title = $_POST['title'];
            $project->description = $_POST['description'];
            $project->save();
        }

        include '../views/addJProject.php';
    }
}