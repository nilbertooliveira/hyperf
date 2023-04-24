<?php

declare(strict_types=1);

namespace App\Services;

use App\Helpers\Helper;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Resource\UserResource;
use App\Services\Interfaces\UserServiceInterface;
use App\Validators\UserValidator;
use Hyperf\Database\Model\ModelNotFoundException;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Qbhy\HyperfAuth\AuthManager;

class UserService implements UserServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    #[Inject]
    private UserRepositoryInterface $userRepository;
    /**
     * @var AuthManager
     */
    #[Inject]
    private AuthManager $authManager;
    /**
     * @var ValidatorFactoryInterface
     */
    #[Inject]
    protected ValidatorFactoryInterface $validationFactory;

    public function login(RequestInterface $request): array
    {
        $result = $this->validate($request, UserValidator::RULE_LOGIN);
        if (!$result['success']) {
            return $result;
        }

        try {
            $user = $this->userRepository->findByEmailAndPassword($request);
        } catch (ModelNotFoundException $e) {
            return Helper::getResponse(false, "Usuario nao encontrado!");
        }

        $token = $this->authManager->guard('jwt')->login($user);

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
        } catch (\Throwable $e) {
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
        $token = $request->header('Authorization');

        $token = is_null($token) ? '' : $token;

        $token = str_replace(["Bearer", "bearer", " "], "", $token);

        try {
            $result = $this->authManager->guard('jwt')->logout($token);
            $message = "Usuario deslogado com sucesso!";
        } catch (\Throwable $e) {
            $result = false;
            $message = $e->getMessage();
        }
        return Helper::getResponse($result, $message);
    }
}