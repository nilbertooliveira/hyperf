<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Model\User;
use Donjan\Casbin\Enforcer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Qbhy\HyperfAuth\Exception\UnauthorizedException;

class PermissionMiddleware implements MiddlewareInterface
{
    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws UnauthorizedException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var User $user */
        $user = $request->getAttribute('user');
        $server = $request->getServerParams();
        $path = strtolower($server['path_info']);
        $method = strtolower($server['request_method']);

        if (Enforcer::enforce($user->email, $path, $method)) {
            return $handler->handle($request);
        }
        throw new UnauthorizedException("Nao autorizado a realizar esta operacao!");
    }
}
