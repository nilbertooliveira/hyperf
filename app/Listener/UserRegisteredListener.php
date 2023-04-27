<?php

declare(strict_types=1);

namespace App\Listener;

use App\Event\UserRegistered;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;

#[Listener]
class UserRegisteredListener implements ListenerInterface
{

    public function listen(): array
    {
       return [
         UserRegistered::class
       ];
    }

    /**
     * @param UserRegistered $event
     * @return void
     */
    public function process(object $event): void
    {
        $event->getUser()->toArray();

        /**
         * @todo sendEmail();
         */

        var_dump($event->getUser()->toArray());
    }
}