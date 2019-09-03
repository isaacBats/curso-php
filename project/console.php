#!/usr/bin/env php
<?php 

require __DIR__.'/vendor/autoload.php';

use App\Commands\HelloWorldCommand;
use App\Commands\SendMailCommand;
use App\Commands\CreateUserCommand;
use Illuminate\Database\Capsule\Manager as Capsule;
use Symfony\Component\Console\Application;

$dotenv = Dotenv\Dotenv::create(__DIR__ );
$dotenv->load();

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => getenv('DB_DRIVER'),
    'host'      => getenv('DB_HOST'),
    'database'  => getenv('DB_NAME'),
    'username'  => getenv('DB_USER'),
    'password'  => getenv('DB_PASS'),
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
    'port'    => getenv('DB_PORT'),
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

$application = new Application();
$application->add(new HelloWorldCommand());
$application->add(new SendMailCommand());
$application->add(new CreateUserCommand());
$application->run();
