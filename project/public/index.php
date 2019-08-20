<?php

ini_set('display_errors', 1);
ini_set('display_starup_error', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Aura\Router\RouterContainer;

    $capsule = new Capsule;

    $capsule->addConnection([
        'driver'    => 'mysql',
        'host'      => '172.17.0.1:3307',
        'database'  => 'php_cursos',
        'username'  => 'root',
        'password'  => 'mysql',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ]);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

function printElement ($job) 
{ ?>
    <li class="work-position">
        <h5><?= $job->title; ?></h5>
        <p><?= $job->description; ?></p>
        <p><?= $job->getDurationAsString(); ?></p>
      <strong>Achievements:</strong>
      <ul>
        <li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>
        <li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>
        <li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>
      </ul>
    </li>
<?php }


$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$routerContainer = new RouterContainer();
$map = $routerContainer->getMap();

$map->get('index', '/', [
    'controller' => 'App\Controllers\IndexController',
    'action' => 'indexAction',
]);
$map->get('addJob', '/jobs/add', [
    'controller' => 'App\Controllers\JobsController',
    'action' => 'getAddJobAction',
]);

$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);

if ( !$route ) {
    echo 'No route';
} else {
    $handlerData = $route->handler;
    $controllerName = $handlerData['controller'];
    $actionName = $handlerData['action'];

    $controller = new $controllerName;
    $controller->$actionName();

}
