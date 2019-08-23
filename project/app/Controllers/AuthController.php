<?php 

namespace App\Controllers;

use App\Models\User;
use \Zend\Diactoros\Response\RedirectResponse;

class AuthController extends BaseController
{
    public function getLogin () {
        return $this->renderHTML('login.twig');
    }

    public function auth ( $request ) {
        $responseMessage = '';
        $postData = $request->getParsedBody();
        $user = User::where('email', $postData['email'])->first();

        if ( $user ) {
            if (password_verify($postData['password'], $user->password)) {
                // var_dump($user); exit;
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