<?php

declare(strict_types=1);

namespace App\Listener;

use App\Event\UserRegistered;
use App\Mail\Mail;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use PHPMailer\PHPMailer\Exception;

#[Listener]
class UserRegisteredListener implements ListenerInterface
{

    private Mail $mail;

    public function __construct(Mail $mail)
    {

        $this->mail = $mail;
    }

    public function listen(): array
    {
        return [
            UserRegistered::class
        ];
    }

    /**
     * @param UserRegistered $event
     * @return void
     * @throws Exception
     */
    public function process(object $event): void
    {
        $event->getUser()->toArray();

        /**
         * @todo sendEmail();
         */

        //$this->mail->send();

        var_dump($event->getUser()->toArray());
    }
}