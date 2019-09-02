<?php 

namespace App\Controllers;

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
        $transport = (new Swift_SmtpTransport(getenv('EMAIL_SMTP'), getenv('EMAIL_PORT')))
          ->setUsername(getenv('EMAIL_USER'))
          ->setPassword(getenv('EMAIL_PASS'));
        $mailer = new Swift_Mailer($transport);

        $htmlParse = "<h1>Contact Form</h1>
            <br><strong>Name:</strong> {$requestData['name']}
            <br><strong>Email:</strong> {$requestData['email']}
            <br><strong>Message:</strong> <p>{$requestData['message']}</p>";

        $message = (new Swift_Message($requestData['subject']))
            ->setFrom(['isaac@danielbat.com' => 'Isaac Batista'])
            ->setTo(['daniel@danielbat.com', 'klonate@gmail.com' => 'Consorcio'])
            ->setBody($htmlParse);

        $result = $mailer->send($message);

        return new RedirectResponse('/contact');
    }
}