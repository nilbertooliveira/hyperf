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

use App\Repositories\ExpenseRepository;
use App\Repositories\Interfaces\ExpenseRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Services\ExpenseService;
use App\Services\Interfaces\ExpenseServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\UserService;

return [
    ExpenseServiceInterface::class    => ExpenseService::class,
    ExpenseRepositoryInterface::class => ExpenseRepository::class,
    UserServiceInterface::class       => UserService::class,
    UserRepositoryInterface::class    => UserRepository::class,
];
