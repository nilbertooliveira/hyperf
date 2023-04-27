<?php

declare(strict_types=1);

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use App\Controller\AuthController;
use App\Controller\ExpenseController;
use App\Controller\UserController;
use App\Middleware\AuthMiddleware;
use App\Middleware\PermissionMiddleware;
use App\Services\GeneratePolicies;
use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

Router::get('/favicon.ico', function () {
    return '';
});


Router::addGroup('/users/', function () {
    Router::post('login', [AuthController::class, 'login']);
    Router::post('logout', [AuthController::class, 'logout'], ['middleware' => [AuthMiddleware::class]]);
    Router::post('create', [UserController::class, 'create'], ['middleware' => [AuthMiddleware::class, PermissionMiddleware::class]]);
    Router::put('update/{id}', [UserController::class, 'update'], ['middleware' => [AuthMiddleware::class, PermissionMiddleware::class]]);
    Router::get('show/{id}', [UserController::class, 'show'], ['middleware' => [AuthMiddleware::class, PermissionMiddleware::class]]);
    Router::get('all', [UserController::class, 'all'], ['middleware' => [AuthMiddleware::class, PermissionMiddleware::class]]);
    Router::get('list-expenses/{id}', [UserController::class, 'listExpenses'], ['middleware' => [AuthMiddleware::class, PermissionMiddleware::class]]);
});

Router::addGroup('/expenses/', function () {
    Router::get('all', [ExpenseController::class, 'all']);
    Router::post('create', [ExpenseController::class, 'create']);
    Router::put('update/{id}', [ExpenseController::class, 'update']);
}, ['middleware' => [AuthMiddleware::class, PermissionMiddleware::class]]);

Router::post('/set-policies', function () {
    /**
     * @todo refatorar();
     */
    new GeneratePolicies();
}, ['middleware' => [AuthMiddleware::class]]);