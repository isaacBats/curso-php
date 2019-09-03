<?php 

namespace App\Controllers;

use App\Models\User;
use Respect\Validation\Validator;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Diactoros\ServerRequest;

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

    public function showUsers () {
        $allUsers = User::all();

        return $this->renderHTML('users/list.twig', compact('allUsers'));
    }

    public function editUser (ServerRequest $request) {
        $id = $request->getAttribute('id');
        $user = User::findOrFail($id);

        return $this->renderHTML('users/edit.twig', compact('user'));
    }

    public function editUserAction (ServerRequest $request) {
        $params = $request->getParsedBody();
        $id = $request->getAttribute('id');
        try {
            $user = User::findOrFail($id);
            $user->name = $params['name'];
            if (!empty($params['password'])) {
                $user->password = password_hash($params['password'], PASSWORD_DEFAULT);
            } 
            $user->save();
        } catch (Exception $e) {
            $log->error($err->getMessage());
        }

        return new RedirectResponse('/admin/users');

    }
}