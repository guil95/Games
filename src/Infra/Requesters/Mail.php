<?php

namespace App\Infra\Requesters;


use App\Games\Game;
use PHPMailer\PHPMailer\PHPMailer;

class Mail
{
    private $mail;

    private function __construct(string $body, Game $game, string $email)
    {
        try {

            $conf = require_once('../conf.php');

            echo 'Enviando... '.PHP_EOL;

            $this->mail = new PHPMailer(true);
            $this->mail->SMTPDebug = 0;
            $this->mail->isSMTP();
            $this->mail->CharSet = 'UTF-8';
            $this->mail->Host = $conf['EMAIL_HOST'];
            $this->mail->SMTPAuth = true;
            $this->mail->Username = $conf['EMAIL'];
            $this->mail->Password = $conf['EMAIL_PASSWORD'];
            $this->mail->SMTPSecure = $conf['EMAIL_SMTP_SECURE'];
            $this->mail->Port = $conf['EMAIL_PORT'];

            $this->mail->setFrom($conf['EMAIL'], 'Games');

            $this->addEmailsToSend($email);

            $this->mail->isHTML(true);

            $this->mail->Subject = $game->getName();
            $this->mail->Body = $body;

            if ($this->mail->send()) {
                echo 'E-mail enviado! '.PHP_EOL;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function send(string $body, Game $game, string $email)
    {
        new self($body, $game, $email);
    }
    
    private function addEmailsToSend(string $emails)
    {
        $emails = explode(',', $emails);
        
        foreach ($emails as $email) {
            $this->mail->addAddress(trim($email));
        }
    }
}