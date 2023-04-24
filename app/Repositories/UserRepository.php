<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Model\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var User
     */
    #[Inject]
    private User $user;

    /**
     * @param RequestInterface $request
     * @return User
     */
    public function findByEmailAndPassword(RequestInterface $request) : User
    {
        return User::query()->where(
            'email', '=', $request->input('email'))
            ->where('password', '=', $request->input('password'))
            ->firstOrFail();
    }

    public function create(RequestInterface $request) : User
    {
        return $this->user->create($request->all());
    }
}