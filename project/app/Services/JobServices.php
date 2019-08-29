<?php 

namespace App\Services;

use App\Models\Job;

class JobServices
{
    public function deleteJob ($id) {
        $job = Job::find($id);
        $job->delete();
    }
}