<?php

namespace App\Controllers;

use App\Models\{Job, Project};

class IndexController extends BaseController
{
    public function indexAction () {
        $name = 'Isaac Batista';
        $limitMonths = 18;
        $totalMonths = 0;

        $jobs = Job::all();
        $jobs = array_filter( $jobs->toArray(), function($job) use ($limitMonths) {
            return $job['months'] >= $limitMonths;
        });

        $projects = Project::all();

        return $this->renderHTML('index.twig', compact('name', 'limitMonths', 'totalMonths', 'jobs', 'projects'));
    }
}