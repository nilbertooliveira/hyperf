<?php

declare(strict_types=1);

namespace App\Controller;

use App\Services\Interfaces\UserServiceInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class AuthController extends AbstractController
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
    public function login(RequestInterface $request): ResponseInterface
    {
        $result = $this->userService->login($request);

        return $this->response->json($result)->withStatus($result['status_code']);
    }


    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function logout(RequestInterface $request): ResponseInterface
    {
        $result = $this->userService->logout($request);

        return $this->response->json($result)->withStatus($result['status_code']);
    }
}
