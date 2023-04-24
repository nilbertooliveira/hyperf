<?php

declare(strict_types=1);

namespace App\Services;

use App\Helpers\Helper;
use App\Repositories\Interfaces\ExpenseRepositoryInterface;
use App\Resource\ExpensiveResource;
use App\Services\Interfaces\ExpenseServiceInterface;
use App\Validators\ExpensiveValidator;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

class ExpenseService implements ExpenseServiceInterface
{
    /**
     * @var ExpenseRepositoryInterface $expenseRepository
     */
    #[Inject]
    private ExpenseRepositoryInterface $expenseRepository;

    #[Inject]
    protected ValidatorFactoryInterface $validationFactory;


    /**
     * @return array
     */
    public function all(): array
    {
        return Helper::getResponse(true, $this->expenseRepository->all());
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
        /**
         * @todo criar as validacoes
         * @todo criar as polices
         */
        $expense = $this->expenseRepository->create($request);

        //@todo fazer find pelo usuario logado e attach
        //$user->expense()->attach();

        $expensiveResource = new ExpensiveResource($expense);

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
}