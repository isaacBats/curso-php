<?php

namespace App\Controllers;

use App\Models\{Job, Project};

class IndexController extends BaseController
{
    public function indexAction () {
        $name = 'Isaac Batista';
        $limitMonths = 60;
        $totalMonths = 0;

        $jobs = Job::all();

        $projects = Project::all();

        return $this->renderHTML('index.twig', compact('name', 'limitMonths', 'totalMonths', 'jobs', 'projects'));
    }
}