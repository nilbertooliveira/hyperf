<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Model\User;
use Hyperf\Database\Model\Collection;
use Hyperf\HttpServer\Contract\RequestInterface;

interface UserRepositoryInterface
{
    public function findByEmail(RequestInterface $request) : User;

    public function create(RequestInterface $request) : User;

    public function update(RequestInterface $request, int $id) : User;

    public function show(int $id) : User;

    public function all() : Collection;

    public function listExpenses(int $id): Collection;
}