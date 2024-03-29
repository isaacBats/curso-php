<?php

namespace App\Controllers;

use App\Models\Job;
use App\Services\JobService;
use Respect\Validation\Validator;
use \Zend\Diactoros\ServerRequest;
use \Zend\Diactoros\Response\RedirectResponse;

class JobsController extends BaseController
{
    private $jobService;

    public function __construct (JobService $jobService) {
        parent::__construct();
        $this->jobService = $jobService;
    }

    public function getAddJobAction ( $request ) {
        $responseMessage = '';

        if ( $request->getMethod() == 'POST' ) {
            $jobValidator = Validator::key('title', Validator::stringType()->notEmpty())
                ->key('description', Validator::stringType()->notEmpty());
            try {
                $postData = $request->getParsedBody();
                $jobValidator->assert($postData);
                
                $files = $request->getUploadedFiles();
                $logo = $files['logo']; 

                if ( $logo->getError() == UPLOAD_ERR_OK ) {
                    $filename = $logo->getClientFilename();
                    $explodeFilename = explode(".", $filename);
                    if ( sizeof($explodeFilename) > 2 ) {
                        $newName = sha1(implode("_", $explodeFilename) . '_' . uniqid()) . '.' . end($explodeFilename);
                    } else {
                        $newName = sha1($filename . '_' . uniqid()) . '.' . $explodeFilename[1];
                    }
                    $logo->moveTo("uploads/{$newName}");
                }
                
                $job = new \App\Models\Job();
                $job->title = $postData['title'];
                $job->description = $postData['description'];
                $job->img_name = isset($filename) ? $filename : null;
                $job->img_path = isset($newName) ? "uploads/{$newName}" : null;
                $job->save();
                $responseMessage = 'Saved';
            } catch (\Exception $e) {
                $responseMessage =  "Error: {$e->getMessage()}";
            }
        }

        return $this->renderHTML('addJob.twig', compact('responseMessage'));
    }

    public function indexAction () {

        $jobs = Job::withTrashed()->get();

        return $this->renderHTML('jobs/index.twig', compact('jobs'));
    }

    public function deleteAction (ServerRequest $request) {
        $params = $request->getQueryParams();
        $this->jobService->deleteJob($params['id']);

        return new RedirectResponse('/jobs');
    }

    public function activeJob( ServerRequest $request ) {
        $params = $request->getQueryParams();
        $job = Job::onlyTrashed()->find($params['id'])->restore();

        return new RedirectResponse('/jobs');
    }

}