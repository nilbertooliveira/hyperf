<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Model\Expense;
use App\Repositories\Interfaces\ExpenseRepositoryInterface;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Model;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

class ExpenseRepository implements ExpenseRepositoryInterface
{
    /**
     * @var Expense
     */
    #[Inject]
    protected Expense $expense;

    public function all(): Collection
    {
        return $this->expense->all();
    }


    /**
     * @param RequestInterface $request
     * @return Expense
     */
    public function create(RequestInterface $request): Expense
    {
        return $this->expense->create($request->all());
    }

    public function update(RequestInterface $request, int $id): Expense
    {
        $expense = $this->expense->query()->findOrFail($id);

        $attributes = [
            'description' => $request->has('description') ? $request->input('description') : $expense->description,
            'price'       => $request->has('price') ? $request->input('price') : $expense->price,
        ];

        $expense->update($attributes);

        return $expense->refresh();
    }
}