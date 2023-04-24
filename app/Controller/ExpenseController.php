<?php

declare(strict_types=1);

namespace App\Controller;

use App\Services\Interfaces\ExpenseServiceInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

class ExpenseController
{

    /**
     * @var ExpenseServiceInterface $expenseService
     */
    #[Inject]
    private ExpenseServiceInterface $expenseService;

    public function index(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        return $response->json($this->expenseService->all());
    }

    public function create(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        return $response->json($this->expenseService->create($request));
    }
}
