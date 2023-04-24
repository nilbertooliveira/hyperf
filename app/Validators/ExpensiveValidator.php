<?php

declare(strict_types=1);

namespace App\Validators;

class ExpensiveValidator
{
    public const RULE = [
        'description' => 'required|string|min:1|max:255',
        'price'       => 'required|numeric|between:0,9999999999.99',
    ];
}