<?php

declare(strict_types=1);

namespace App\Event;

use App\Model\User;

class UserRegistered
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}