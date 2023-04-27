<?php

declare(strict_types=1);

namespace App\Controller;

use App\Services\Interfaces\UserServiceInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class UserController extends AbstractController
{
    /**
     * @var UserServiceInterface
     */
    #[Inject]
    private UserServiceInterface $userService;

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function create(RequestInterface $request): ResponseInterface
    {
        $result = $this->userService->create($request);

        return $this->response->json($result)->withStatus($result['status_code']);
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function update(RequestInterface $request, int $id): ResponseInterface
    {
        $result = $this->userService->update($request, $id);

        return $this->response->json($result)->withStatus($result['status_code']);
    }

    /**
     * @param int $id
     * @return ResponseInterface
     */
    public function show(int $id): ResponseInterface
    {
        $result = $this->userService->show($id);

        return $this->response->json($result)->withStatus($result['status_code']);
    }

    /**
     * @return ResponseInterface
     */
    public function all(): ResponseInterface
    {
        $result = $this->userService->all();

        return $this->response->json($result)->withStatus($result['status_code']);
    }

    public function listExpenses(int $id): ResponseInterface
    {
        $result = $this->userService->listExpenses($id);

        return $this->response->json($result)->withStatus($result['status_code']);
    }

}
