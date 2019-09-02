<?php
require_once '../vendor/autoload.php';

session_start();

$dotenv = Dotenv\Dotenv::create(__DIR__ . '/..');
$dotenv->load();

if (getenv('DEBUG') === true) {
    ini_set('display_errors', 1);
    ini_set('display_starup_error', 1);
    error_reporting(E_ALL);
}

use Aura\Router\RouterContainer;
use Franzl\Middleware\Whoops\WhoopsMiddleware;
use Illuminate\Database\Capsule\Manager as Capsule;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use WoohooLabs\Harmony\Harmony;
use WoohooLabs\Harmony\Middleware\DispatcherMiddleware;
use WoohooLabs\Harmony\Middleware\FastRouteMiddleware;
use WoohooLabs\Harmony\Middleware\HttpHandlerRunnerMiddleware;
use Zend\Diactoros\Response;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

$log = new Logger('app');
$log->pushHandler(new StreamHandler(__DIR__ . '/../logs/app.log'), Logger::WARNING);

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
    'auth' => true,
]);

$map->get('indexJobs', '/jobs', [
    'App\Controllers\JobsController',
    'indexAction',
    'auth' => true,
]);

$map->post('saveJob', '/jobs/add', [
    'App\Controllers\JobsController',
    'getAddJobAction',
    'auth' => true,
]);

$map->get('addProject', '/projects/add', [
    'App\Controllers\ProjectsController',
    'getAddProjectAction',
    'auth' => true,
]);

$map->post('saveProject', '/projects/add', [
    'App\Controllers\ProjectsController',
    'getAddProjectAction',
    'auth' => true,
]);

$map->get('tasksList', '/tasks/list', [
    'App\Controllers\TasksController',
    'getListTaskAction',
    'auth' => true,
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
    'auth' => true,
]);

$map->post('auth', '/auth', [
    'App\Controllers\AuthController',
    'auth',
]);

$map->get('admin', '/admin', [
    'App\Controllers\AdminController',
    'index',
    'auth' => true,
]);

$map->get('deleteJobs', '/jobs/delete', [
    'App\Controllers\JobsController',
    'deleteAction',
    'auth' => true,
]);

$map->get('restoreJob', '/jobs/restore', [
    'App\Controllers\JobsController',
    'activeJob',
    'auth' => true,
]);

$map->get('contactForm', '/contact', [
    'App\Controllers\ContactController',
    'index',
]);

$map->post('contactAction', '/contact/send', [
    'App\Controllers\ContactController',
    'sendAction',
]);


$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);

if ( !$route ) {
    echo 'No route';
} else {
    try {
        $handlerData = $route->handler;
        $_SERVER['auth'] = $handlerData['auth'] ?? false;
        
        $harmony = new Harmony($request, new Response());
        $harmony->addMiddleware(new HttpHandlerRunnerMiddleware(new SapiEmitter()));
            if (getenv('DEBUG') === true) {
                $harmony->addMiddleware(new WhoopsMiddleware);
            }
        $harmony->addMiddleware(new App\Middlewares\AuthenticationMiddleware())
            ->addMiddleware(new Middlewares\AuraRouter($routerContainer))
            ->addMiddleware(new DispatcherMiddleware($container, 'request-handler'))
            ->run();
    } catch (Exception $e) {
        // No se agrega ningun tipo de mensaje por seguridad. Asi quien esta viendo la pantalla no sabe que fallo
        // Esto es por temas de seguridad de la aplicación. Que se recomienda no poner en donde esta fallando la aplicación.
        // Aunque esta parte se puede tambien mandar un response con HTML. Y asi mostrar un mensaje agradable al usuario.
        $log->warning($e->getMessage());
        $emmiter = new SapiEmitter();
        $emmiter->emit(new Response\EmptyResponse(400));
    } catch (Error $err) {
        $log->error($err->getMessage());
        $emmiter = new SapiEmitter();
        $emmiter->emit(new Response\EmptyResponse(500));
    }
}
