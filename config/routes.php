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
use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

Router::get('/favicon.ico', function () {
    return '';
});


Router::addGroup('/users/', function (){
    Router::post('login', [AuthController::class, 'login']);
    Router::post('create', [AuthController::class, 'create']);
    Router::post('logout', [AuthController::class, 'logout']);
});

Router::addGroup('/expenses', function (){
    Router::get('', [ExpenseController::class, 'index']);
    Router::post('', [ExpenseController::class, 'create']);
});
