<?php

namespace App\Commands;

use App\Models\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends Command
{

    protected static $defaultName = 'app:create-user';

    protected function execute(InputInterface $input, OutputInterface $output) {
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);

        $password = ($input->getArgument('pass')) ? $input->getArgument('pass') : User::generatePassword(12);

        $user = new User();
        $user->name = $input->getArgument('name');
        $user->email = $input->getArgument('email');
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->save();

        $output->writeln("Your password: {$password}");
        $output->writeln('Done.');
    }

    protected function configure() {

        $this->addArgument('email', InputArgument::REQUIRED, 'The email of the user.');
        $this->addArgument('name', InputArgument::REQUIRED, 'The name of the user.');
        $this->addArgument('pass', InputArgument::OPTIONAL, 'A password of the user.');
    }
}