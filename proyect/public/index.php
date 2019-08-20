<?php

ini_set('display_errors', 1);
ini_set('display_starup_error', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

    $capsule = new Capsule;

    $capsule->addConnection([
        'driver'    => 'mysql',
        'host'      => '127.0.0.1:3307',
        'database'  => 'php_cursos',
        'username'  => 'root',
        'password'  => 'mysql',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ]);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

$route = $_GET['route'] ?? '/';

if ( $route == '/' ) {
    require '../index.php';
} elseif ($route == 'addJob') {
    require '../addJob.php';
} elseif ( $route == 'addProject') {
    require '../addProject.php';
}
