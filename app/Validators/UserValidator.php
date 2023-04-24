<?php

declare(strict_types=1);

namespace App\Validators;

class UserValidator
{
    public const RULE_LOGIN = [
        'email'    => 'required|email',
        'password' => 'required|min:1|max:255',
    ];

    public const RULE_CREATE = [
        'name'     => 'required|string|min:1|max:255',
        'email'    => 'required|email',
        'password' => 'required|min:1|max:255',
    ];
}