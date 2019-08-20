<?php

namespace App\Controllers;

class JobsController extends BaseController
{
    public function getAddJobAction ( $request ) {
        if ( $request->getMethod() == 'POST' ) {
            $postData = $request->getParsedBody();
            $job = new \App\Models\Job();
            $job->title = $postData['title'];
            $job->description = $postData['description'];
            $job->save();
        }

        return $this->renderHTML('addJob.twig');
    }

}