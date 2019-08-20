<?php

namespace App\Controllers;

use App\Models\{Job, Project};

class IndexController
{
    public function indexAction () {
        $name = 'Isaac Batista';
        $limitMonths = 60;
        $totalMonths = 0;

        $jobs = Job::all();

        $projects = Project::all();

        include '../views/index.php';
    }
}