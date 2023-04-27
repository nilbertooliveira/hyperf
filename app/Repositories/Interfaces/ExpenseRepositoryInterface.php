<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Model\Expense;
use Hyperf\Database\Model\Collection;
use Hyperf\HttpServer\Contract\RequestInterface;

interface ExpenseRepositoryInterface
{
    public function all() : Collection;

    public function create(RequestInterface $request): Expense;

    public function update(RequestInterface $request, int $id) : Expense;
}