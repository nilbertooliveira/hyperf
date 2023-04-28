<?php

namespace App\Mail;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

/**
 * @todo classe temporaria de teste, precisa ser refatorada
 */
class Mail
{

    /** @var PHPMailer */
    private PHPMailer $PHPMailer;

    public function __construct()
    {
        $this->PHPMailer = new PHPMailer(true);

        $this->getPHPMailer()->Username = \Hyperf\Support\env('MAIL_USERNAME');
        $this->getPHPMailer()->Password = \Hyperf\Support\env('MAIL_PASSWORD');
        $this->getPHPMailer()->Host = \Hyperf\Support\env('MAIL_HOST');
        $this->getPHPMailer()->Port = \Hyperf\Support\env('MAIL_PORT');
        $this->getPHPMailer()->AuthType = \Hyperf\Support\env('MAIL_AUTH_TYPE');
        $this->getPHPMailer()->SMTPDebug = SMTP::DEBUG_SERVER;
        $this->getPHPMailer()->isSMTP();
        $this->getPHPMailer()->isHTML(true);
        $this->getPHPMailer()->SMTPAuth = true;
        $this->getPHPMailer()->SMTPSecure = 'tls';
    }


    /**
     * @return PHPMailer
     */
    public function getPHPMailer(): PHPMailer
    {
        return $this->PHPMailer;
    }

    /**
     * @throws Exception
     */
    public function send(): bool
    {
        $this->getPHPMailer()->setFrom("nilberto.oliveira@onfly.com.br", "Nilberto Oliveira");
        $this->getPHPMailer()->addAddress("nilberto.oliveira@onfly.com.br", 'NIlberto Oliveira');
        $this->getPHPMailer()->addAddress("nilberto.teste@onfly.com.br", 'NIlberto Teste');
        $this->getPHPMailer()->Subject = "Teste de assunto!";
        $this->getPHPMailer()->Body = "Teste de body!";

        return $this->getPHPMailer()->send();
    }


}