<?php

namespace App\Mail;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mail
{

    /** @var PHPMailer */
    private PHPMailer $mail;

    private string $from;

    private array $to;

    private string $subject;

    private string $body;

    private bool $isHTML = true;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);

        $this->getMail()->Username = \Hyperf\Support\env('MAIL_USERNAME');
        $this->getMail()->Password = \Hyperf\Support\env('MAIL_PASSWORD');
        $this->getMail()->Host = \Hyperf\Support\env('MAIL_HOST');
        $this->getMail()->Port = \Hyperf\Support\env('MAIL_PORT');
        $this->getMail()->AuthType = \Hyperf\Support\env('MAIL_AUTH_TYPE');
        $this->setFrom("nilberto.oliveira@onfly.com.br");
        $this->setTo([
            "nilberto.oliveira@onfly.com.br",
            "nilberto.teste@onfly.com.br",
        ]);
        $this->setSubject("Teste de assunto!");
        $this->setBody("Teste de body!");
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @param string $from
     */
    public function setFrom(string $from): void
    {
        $this->from = $from;
    }

    /**
     * @return array
     */
    public function getTo(): array
    {
        return $this->to;
    }

    /**
     * @param array $to
     */
    public function setTo(array $to): void
    {
        $this->to = $to;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * @return bool
     */
    public function isHTML(): bool
    {
        return $this->isHTML;
    }

    /**
     * @param bool $isHTML
     */
    public function setIsHTML(bool $isHTML): void
    {
        $this->isHTML = $isHTML;
    }

    /**
     * @return PHPMailer
     */
    public function getMail(): PHPMailer
    {
        return $this->mail;
    }

    /**
     * @throws Exception
     */
    public function send(): bool
    {
        foreach ($this->getTo() as $to) {
            $this->getMail()->addAddress($to,  $to);
        }

        $this->getMail()->SMTPDebug = SMTP::DEBUG_SERVER;
        $this->getMail()->isSendmail();
        $this->getMail()->Sendmail = '/usr/sbin/sendmail -S 54.80.103.13 -t -i';
        $this->getMail()->SMTPAuth = false;
        $this->getMail()->isHTML($this->isHTML());
        $this->getMail()->Subject = $this->getSubject();
        $this->getMail()->setFrom($this->getFrom(), $this->getFrom());
        $this->getMail()->Body = $this->getBody();

        return $this->getMail()->send();
    }
}