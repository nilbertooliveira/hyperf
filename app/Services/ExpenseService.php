<?php

declare(strict_types=1);

namespace App\Services;

use App\Helpers\Helper;
use App\Model\User;
use App\Repositories\Interfaces\ExpenseRepositoryInterface;
use App\Resource\ExpensiveResource;
use App\Services\Interfaces\ExpenseServiceInterface;
use App\Validators\ExpensiveValidator;
use Carbon\Carbon;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

class ExpenseService implements ExpenseServiceInterface
{
    /**
     * @var ExpenseRepositoryInterface
     */
    #[Inject]
    protected ExpenseRepositoryInterface $expenseRepository;

    /**
     * @var ValidatorFactoryInterface
     */
    #[Inject]
    protected ValidatorFactoryInterface $validationFactory;

    /**
     * @var EmailService
     */
    #[Inject]
    protected EmailService $emailService;

    /**
     * @return array
     */
    public function all(): array
    {
        $expenses = $this->expenseRepository->all();

        $expensiveResource = ExpensiveResource::collection($expenses);

        return Helper::getResponse(true, $expensiveResource);
    }

    /**
     * @param RequestInterface $request
     * @return array
     */
    public function create(RequestInterface $request): array
    {
        $result = $this->validate($request);
        if (!$result['success']) {
            return $result;
        }

        try {
            /** @var User $user */
            $user = $request->getAttribute('user');

            $expense = $this->expenseRepository->create($request);

            $user->expense()->attach($expense->id, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $expensiveResource = new ExpensiveResource($expense);

            //$this->emailService->push($expense);
        } catch (\Throwable $e) {
            return Helper::getResponse(false, $e->getMessage());
        }

        return Helper::getResponse(true, $expensiveResource);
    }

    /**
     * @param RequestInterface $request
     * @return array
     */
    private function validate(RequestInterface $request): array
    {
        $validator = $this->validationFactory->make(
            $request->all(),
            ExpensiveValidator::RULE
        );

        if ($validator->fails()) {
            return Helper::getResponse(false, $validator->errors()->getMessages());
        }
        return Helper::getResponse(true, null);
    }

    public function update(RequestInterface $request, int $id): array
    {
        try {
            $expense = $this->expenseRepository->update($request, $id);

            $expensiveResource = new ExpensiveResource($expense);

        } catch (\Throwable $e) {
            return Helper::getResponse(false, $e->getMessage());
        }

        return Helper::getResponse(true, $expensiveResource);
    }
}