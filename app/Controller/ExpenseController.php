<?php

declare(strict_types=1);

namespace App\Controller;

use App\Services\Interfaces\ExpenseServiceInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ExpenseController extends AbstractController
{

    /**
     * @var ExpenseServiceInterface
     */
    #[Inject]
    private ExpenseServiceInterface $expenseService;

    public function all(): ResponseInterface
    {
        return $this->response->json($this->expenseService->all());
    }

    public function create(RequestInterface $request): ResponseInterface
    {
        return $this->response->json($this->expenseService->create($request));
    }

    public function update(RequestInterface $request, int $id): ResponseInterface
    {
        return $this->response->json($this->expenseService->update($request, $id));
    }

    public function show(int $userId): ResponseInterface
    {
        return $this->response->json($this->expenseService->show($userId));
    }
}
