<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Model\User;
use Hyperf\HttpServer\Contract\RequestInterface;

interface UserRepositoryInterface
{
    public function findByEmailAndPassword(RequestInterface $request) : User;

    public function create(RequestInterface $request) : User;
}