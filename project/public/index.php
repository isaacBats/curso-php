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

$map->post('saveJob', '/jobs/add', [
    'controller' => 'App\Controllers\JobsController',
    'action' => 'getAddJobAction',
]);

$map->get('addProject', '/projects/add', [
    'controller' => 'App\Controllers\ProjectsController',
    'action' => 'getAddProjectAction',
]);

$map->post('saveProject', '/projects/add', [
    'controller' => 'App\Controllers\ProjectsController',
    'action' => 'getAddProjectAction',
]);

$map->get('tasksList', '/tasks/list', [
    'controller' => 'App\Controllers\TasksController',
    'action' => 'getListTaskAction',
]);

$map->get('register', '/register', [
    'controller' => 'App\Controllers\UserController',
    'action' => 'register',
]);

$map->post('registerAction', '/register', [
    'controller' => 'App\Controllers\UserController',
    'action' => 'register',
]);

$map->get('loginView', '/login', [
    'controller' => 'App\Controllers\AuthController',
    'action' => 'getLogin',
]);

$map->post('auth', '/auth', [
    'controller' => 'App\Controllers\AuthController',
    'action' => 'auth',
]);

$map->get('admin', '/admin', [
    'controller' => 'App\Controllers\AdminController',
    'action' => 'index',
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
    $response = $controller->$actionName($request);

    foreach ($response->getHeaders() as $name => $values) {
        foreach ($values as $value) {
            header(sprintf('%s: %s', $name, $value), false);
        }
    }
    http_response_code($response->getStatusCode());
    echo $response->getBody();
}
