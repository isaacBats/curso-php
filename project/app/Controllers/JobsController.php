<?php

namespace App\Controllers;

use Respect\Validation\Validator;

class JobsController extends BaseController
{
    public function getAddJobAction ( $request ) {
        $responseMessage = '';

        if ( $request->getMethod() == 'POST' ) {
            $postData = $request->getParsedBody();
            $jobValidator = Validator::key('title', Validator::stringType()->notEmpty())
                ->key('description', Validator::stringType()->notEmpty());
            try {
                $jobValidator->assert($postData);
                $job = new \App\Models\Job();
                $job->title = $postData['title'];
                $job->description = $postData['description'];
                $job->save();
                $responseMessage = 'Saved';
            } catch (\Exception $e) {
                $responseMessage =  "Error: {$e->getMessage()}";
            }
        }

        return $this->renderHTML('addJob.twig', compact('responseMessage'));
    }

}