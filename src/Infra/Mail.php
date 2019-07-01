<?php

namespace App\Infra;


use App\Games\Game;
use PHPMailer\PHPMailer\PHPMailer;

class Mail
{
    public static function send(string $body, Game $game)
    {
        try {
            $mail = new PHPMailer(true);
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host = 'smtp.live.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'EMAIL';
            $mail->Password = 'SENHA';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 465;

            $mail->setFrom('EMAIL', 'Games');
            $mail->addAddress('EMAIL');

            $mail->isHTML(true);

            $mail->Subject = $game->getName();
            $mail->Body = $body;

            $mail->send();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}