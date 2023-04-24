<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use Hyperf\HttpServer\Contract\RequestInterface;

interface ExpenseServiceInterface
{
    public function all(): array;

    public function create(RequestInterface $request): array;
}