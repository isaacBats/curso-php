<?php 

namespace App\Controllers;

use App\Models\Message;
use App\Models\User;
use Respect\Validation\Validator as v;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Zend\Diactoros\Response\RedirectResponse;

class ContactController extends BaseController 
{
    public function index () {
        return $this->renderHTML('contact.twig');
    } 

    public function sendAction ($request) {
        $requestData = $request->getParsedBody();

        $message = new Message();
        $message->name = $requestData['name'];
        $message->email = $requestData['email'];
        $message->subject = $requestData['subject'];
        $message->message = $requestData['message'];
        $message->sent = false;

        $message->save();
        
        return new RedirectResponse('/contact');
    }
}