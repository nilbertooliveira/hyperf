<?php

declare(strict_types=1);

namespace App\Services;

use App\Event\UserRegistered;
use App\Helpers\Helper;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Resource\ExpensiveResource;
use App\Resource\UserResource;
use App\Services\Interfaces\UserServiceInterface;
use App\Validators\UserValidator;
use Carbon\Carbon;
use Hyperf\Database\Model\ModelNotFoundException;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Qbhy\HyperfAuth\AuthManager;
use Throwable;

class UserService implements UserServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    #[Inject]
    protected UserRepositoryInterface $userRepository;
    /**
     * @var AuthManager
     */
    #[Inject]
    protected AuthManager $authManager;
    /**
     * @var ValidatorFactoryInterface
     */
    #[Inject]
    protected ValidatorFactoryInterface $validationFactory;

    #[Inject]
    protected EventDispatcherInterface $eventDispatcher;

    /**
     * @GetMapping(path="/login")
     * @param RequestInterface $request
     * @return array
     */
    public function login(RequestInterface $request): array
    {
        $result = $this->validate($request, UserValidator::RULE_LOGIN);
        if (!$result['success']) {
            return $result;
        }

        try {
            $user = $this->userRepository->findByEmail($request);

            if (!password_verify($request->input('password'), $user->password)) {
                return Helper::getResponse(false, "Senha incorreta!");
            }
        } catch (ModelNotFoundException $e) {
            return Helper::getResponse(false, "Usuario nao encontrado!");
        }

        $ttl = Carbon::now()->addMinutes(120)->getTimestamp();
        //$ttl = Carbon::now()->getTimestamp();

        $token = $this->authManager
            ->guard('jwt')
            ->login($user, [
                'uid'   => $user->id,
                'iss'   => 'hyperf-auth',
                'exp'   => $ttl,
                'email' => $request->input('email')
            ]);

        return Helper::getResponse(true, ['token' => $token]);
    }

    public function create(RequestInterface $request): array
    {
        $result = $this->validate($request, UserValidator::RULE_CREATE);
        if (!$result['success']) {
            return $result;
        }

        try {
            $user = $this->userRepository->create($request);

            $userResource = new UserResource($user);

            $this->eventDispatcher->dispatch(new UserRegistered($user));
        } catch (Throwable $e) {
            return Helper::getResponse(false, $e->getMessage());
        }

        return Helper::getResponse(true, $userResource);

    }

    private function validate(RequestInterface $request, array $rule): array
    {
        $validator = $this->validationFactory->make(
            $request->all(),
            $rule
        );

        if ($validator->fails()) {
            return Helper::getResponse(false, $validator->errors()->getMessages());
        }
        return Helper::getResponse(true, null);
    }

    public function logout(RequestInterface $request): array
    {
        $token = $request->getAttribute('token');

        try {
            $result = $this->authManager->guard('jwt')->logout($token);
            $message = "Usuario deslogado com sucesso!";
        } catch (Throwable $e) {
            $result = false;
            $message = $e->getMessage();
        }
        return Helper::getResponse($result, $message);
    }

    public function show(int $id): array
    {
        try {
            $user = $this->userRepository->show($id);

            $userResource = new UserResource($user);

        } catch (Throwable $e) {
            return Helper::getResponse(false, $e->getMessage());
        }

        return Helper::getResponse(true, $userResource);
    }

    public function all(): array
    {
        try {
            $user = $this->userRepository->all();

            $userResource = UserResource::collection($user);

        } catch (Throwable $e) {
            return Helper::getResponse(false, $e->getMessage());
        }

        return Helper::getResponse(true, $userResource);
    }

    public function update(RequestInterface $request, int $id): array
    {
        try {
            $user = $this->userRepository->update($request, $id);

            $userResource = new UserResource($user);

        } catch (Throwable $e) {
            return Helper::getResponse(false, $e->getMessage());
        }

        return Helper::getResponse(true, $userResource);
    }

    public function listExpenses(int $id): array
    {
        try {
            $expenses = $this->userRepository->listExpenses($id);

            $expensiveResource = ExpensiveResource::collection($expenses);

        } catch (Throwable $e) {
            return Helper::getResponse(false, $e->getMessage());
        }

        return Helper::getResponse(true, $expensiveResource);
    }
}