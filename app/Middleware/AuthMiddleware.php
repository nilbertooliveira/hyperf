<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Model\User;
use Hyperf\Di\Annotation\Inject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Qbhy\HyperfAuth\AuthManager;
use Qbhy\HyperfAuth\Exception\UnauthorizedException;

class AuthMiddleware implements MiddlewareInterface
{
    /**
     * @var AuthManager
     */
    #[Inject]
    protected AuthManager $authManager;

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws UnauthorizedException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$request->hasHeader('Authorization')) {
            throw new UnauthorizedException("Token inexistente!");
        }

        $authorization = $request->getHeaderLine('Authorization');

        $token = str_replace(["Bearer", "bearer", " "], "", $authorization);

        $guard = $this->authManager->guard('jwt');

        /**
         * @var User $user
         */
        $user = $guard->user($token);

        $request = $request->withAttribute('user', $user);

        $request = $request->withAttribute('token', $token);

        return $handler->handle($request);
    }
}
