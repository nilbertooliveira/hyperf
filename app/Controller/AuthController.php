<?php

declare(strict_types=1);

namespace App\Controller;

use App\Services\Interfaces\UserServiceInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

class AuthController
{
    /**
     * @var UserServiceInterface $userService
     */
    #[Inject]
    private UserServiceInterface $userService;

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function login(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        $result = $this->userService->login($request);

        return $response->json($result)->withStatus($result['status_code']);
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function create(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        $result = $this->userService->create($request);

        return $response->json($result)->withStatus($result['status_code']);
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function logout(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        $result = $this->userService->logout($request);

        return $response->json($result)->withStatus($result['status_code']);
    }

}
