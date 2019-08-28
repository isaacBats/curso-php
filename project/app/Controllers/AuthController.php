<?php 

namespace App\Controllers;

use App\Models\User;
use \Zend\Diactoros\Response\RedirectResponse;
use \Zend\Diactoros\ServerRequest;

class AuthController extends BaseController
{
    public function getLogin () {
        return $this->renderHTML('login.twig');
    }

    public function getLogout () {
        unset($_SESSION['userId']);
        return new RedirectResponse('/login');
    }

    public function auth ( ServerRequest $request ) {
        $responseMessage = '';
        $postData = $request->getParsedBody();
        $user = User::where('email', $postData['email'])->first();

        if ( $user ) {
            if (password_verify($postData['password'], $user->password)) {
                $_SESSION['userId'] = $user->id;
                return new RedirectResponse('/admin');
            } else {
                $responseMessage =  'Contraseña ó usuario incorrect@';
            }
        } else {
            $responseMessage =  'Contraseña ó usuario incorrect@';
        }

        return $this->renderHTML('login.twig', compact('responseMessage'));
    }
}