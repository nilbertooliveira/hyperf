<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use Hyperf\HttpServer\Contract\RequestInterface;

interface UserServiceInterface
{

    public function login(RequestInterface $request) : array;

    public function create(RequestInterface $request) : array;

    public function logout(RequestInterface $request) : array;
}