<?php 

namespace App\Controllers;

use Respect\Validation\Validator;

class UserController extends BaseController
{
    public function register ( $request ) {
        $responseMessage = '';

        if ( $request->getMethod() == 'POST' ) {
            $userValidator = Validator::key('name', Validator::stringType()->notEmpty())
                ->key('email', Validator::Email()->notEmpty())
                ->key('password', Validator::stringType()->notEmpty());

            try {
                $postData = $request->getParsedBody();
                $userValidator->assert($postData);
                
                $user = new \App\Models\User();
                $user->name = $postData['name'];
                $user->email = $postData['email'];
                $user->password = password_hash($postData['password'], PASSWORD_DEFAULT);
                $user->save();

                
                $responseMessage = 'Saved';
            } catch (\Exception $e) {
                $responseMessage = $e->getMessage();
            }
        }

        return $this->renderHTML('register.twig', compact('responseMessage'));
    }
}