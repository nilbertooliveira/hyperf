<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Model\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Hyperf\Database\Model\Collection;
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
    public function findByEmail(RequestInterface $request): User
    {
        return $this->user->query()->where(
            'email', '=', $request->input('email'))
            ->firstOrFail();
    }

    public function create(RequestInterface $request): User
    {
        $attributes = [
            'name'     => $request->input('name'),
            'email'    => $request->input('email'),
            'password' => password_hash($request->input('password'), PASSWORD_BCRYPT),

        ];
        return $this->user->create($attributes);
    }

    public function show(int $id): User
    {
        return $this->user->query()->findOrFail($id);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->user->query()->get();
    }

    /**
     * @param RequestInterface $request
     * @param int $id
     * @return User
     */
    public function update(RequestInterface $request, int $id): User
    {
        $user = $this->user->query()->findOrFail($id);

        $attributes = [
            'name'     => $request->has('name') ? $request->input('name') : $user->name,
            'email'    => $request->has('email') ? $request->input('email') : $user->email,
            'password' => $request->has('email') ? password_hash($request->input('password'), PASSWORD_BCRYPT) : $user->password,
        ];

        $user->update($attributes);

        return $user->refresh();
    }

    public function listExpenses(int $id): Collection
    {
        return $this->user->findOrFail($id)->expense()->get();
    }
}