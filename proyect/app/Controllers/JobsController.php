<?php

namespace App\Controllers;

class JobsController
{
    public function getAddJobAction () {
        if ( !empty($_POST) ) {
            $job = new App\Models\Job();
            $job->title = $_POST['title'];
            $job->description = $_POST['description'];
            $job->save();
        }

        include '../views/addJob.php';
    }
}