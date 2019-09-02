<?php

namespace App\Commands;

use App\Models\Message;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class SendMailCommand extends Command
{
    protected static $defaultName = 'app:send-mail';

    protected function execute(InputInterface $input, OutputInterface $output) {
        
        $pendingMessage = Message::where('sent', false)->first();

        if($pendingMessage) {
            $transport = (new Swift_SmtpTransport(getenv('EMAIL_SMTP'), getenv('EMAIL_PORT')))
              ->setUsername(getenv('EMAIL_USER'))
              ->setPassword(getenv('EMAIL_PASS'));
            $mailer = new Swift_Mailer($transport);

            $htmlParse = "<h1>Contact Form</h1>
                <br><strong>Name:</strong> {$pendingMessage->name}
                <br><strong>Email:</strong> {$pendingMessage->email}
                <br><strong>Message:</strong> <p>{$pendingMessage->message}</p>";

            $message = (new Swift_Message($pendingMessage->subject))
                ->setFrom(['isaac@danielbat.com' => 'Isaac Batista'])
                ->setTo(['daniel@danielbat.com', 'klonate@gmail.com' => 'Consorcio'])
                ->setBody($htmlParse);

            $result = $mailer->send($message);

            $pendingMessage->sent = true;
            $pendingMessage->save();
        }


    }
}