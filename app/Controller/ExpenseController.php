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
    protected ExpenseServiceInterface $expenseService;

    public function all(): ResponseInterface
    {
        $result = $this->expenseService->all();

        return $this->response->json($result)->withStatus($result['status_code']);
    }

    public function create(RequestInterface $request): ResponseInterface
    {
        $result = $this->expenseService->create($request);

        return $this->response->json($result)->withStatus($result['status_code']);
    }

    public function update(RequestInterface $request, int $id): ResponseInterface
    {
        $result = $this->expenseService->update($request, $id);

        return $this->response->json($result)->withStatus($result['status_code']);
    }
}
