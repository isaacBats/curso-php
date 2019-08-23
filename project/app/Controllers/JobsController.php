<?php

namespace App\Controllers;

use Respect\Validation\Validator;

class JobsController extends BaseController
{
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

}