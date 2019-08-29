<?php

ini_set('display_errors', 1);
ini_set('display_starup_error', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

session_start();

$dotenv = Dotenv\Dotenv::create(__DIR__ . '/..');
$dotenv->load();

use Aura\Router\RouterContainer;
use Illuminate\Database\Capsule\Manager as Capsule;
use WoohooLabs\Harmony\Harmony;
use WoohooLabs\Harmony\Middleware\FastRouteMiddleware;
use WoohooLabs\Harmony\Middleware\DispatcherMiddleware;
use WoohooLabs\Harmony\Middleware\HttpHandlerRunnerMiddleware;
use Zend\Diactoros\Response;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

$container = new DI\Container();
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
    'App\Controllers\IndexController',
    'indexAction',
]);

$map->get('addJob', '/jobs/add', [
    'App\Controllers\JobsController',
    'getAddJobAction',
    true,
]);

$map->get('indexJobs', '/jobs', [
    'App\Controllers\JobsController',
    'indexAction',
    true,
]);

$map->post('saveJob', '/jobs/add', [
    'App\Controllers\JobsController',
    'getAddJobAction',
    true,
]);

$map->get('addProject', '/projects/add', [
    'App\Controllers\ProjectsController',
    'getAddProjectAction',
    true,
]);

$map->post('saveProject', '/projects/add', [
    'App\Controllers\ProjectsController',
    'getAddProjectAction',
    true,
]);

$map->get('tasksList', '/tasks/list', [
    'App\Controllers\TasksController',
    'getListTaskAction',
    true,
]);

$map->get('register', '/register', [
    'App\Controllers\UserController',
    'register',
]);

$map->post('registerAction', '/register', [
    'App\Controllers\UserController',
    'register',
]);

$map->get('loginView', '/login', [
    'App\Controllers\AuthController',
    'getLogin',
]);

$map->get('logout', '/logout', [
    'App\Controllers\AuthController',
    'getLogout',
    true,
]);

$map->post('auth', '/auth', [
    'App\Controllers\AuthController',
    'auth',
]);

$map->get('admin', '/admin', [
    'App\Controllers\AdminController',
    'index',
    true,
]);

$map->get('deleteJobs', '/jobs/delete', [
    'App\Controllers\JobsController',
    'deleteAction',
    true,
]);

$map->get('restoreJob', '/jobs/restore', [
    'App\Controllers\JobsController',
    'activeJob',
    true,
]);


$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);

if ( !$route ) {
    echo 'No route';
} else {
    // $handlerData = $route->handler;
    // $controllerName = $handlerData['controller'];
    // $actionName = $handlerData['action'];
    // $needsAuth = $handlerData['auth'] ?? false;

    // $sessionUserId = $_SESSION['userId'] ?? null;
    // if ( $needsAuth && !$sessionUserId ) {
    //     echo 'Protected route';
    //     die;
    // }

    $harmony = new Harmony($request, new Response());
    $harmony
        ->addMiddleware(new HttpHandlerRunnerMiddleware(new SapiEmitter()))
        ->addMiddleware(new Middlewares\AuraRouter($routerContainer))
        ->addMiddleware(new DispatcherMiddleware($container, 'request-handler'))
        ->run();
}
