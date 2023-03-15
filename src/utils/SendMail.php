<?php

namespace Libelulasoft\ErrorHandler\utils;

use Exception;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

class SendMail
{

    private Email $mail;

    private array $cc = [];

    private array $adjuntos = [];

    public function sendMail(
        array $config,
        string $message,
        string $asunto,
        array  $listaAdjuntos = [],
    ) {

        $mailer = $this->connect($config);

        $this->mail = (new Email())
            ->from($config['remitente'])
            ->to($config['to'])
            ->subject($asunto)
            ->html($message);

        $this->cc = array_merge($this->cc, $config['cc'] ?? []);

        foreach ($this->cc as $cc) {
            $this->mail->addCc($cc);
        }

        $this->adjuntos = array_merge($this->adjuntos, $listaAdjuntos);

        foreach ($this->adjuntos as $adjunto) {
            $this->adjunto($adjunto);
        }

        try {
            $mailer->send($this->mail);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function addCc(string $mail)
    {
        $this->cc[] = $mail;
    }

    public function addAdjunto(string $url)
    {
        $this->adjuntos[] = $url;
    }

    private function adjunto(string $url)
    {

        $body = file_get_contents($url);

        $ext = explode('.', $url);
        $ext = end($ext);
        if (!isset($ext) || strlen($ext) != 3) {
            $ext = 'pdf';
        }

        $partes = explode('/', $url);
        $name = str_replace('.', '_', end($partes) ?? '')
            . "_" . date('Ymdhis') . "." . $ext;

        $this->mail->attach($body, $name);
    }

    private function connect(array $config): Mailer
    {
        $user = urlencode($config['user']);
        $cont = urldecode($config['cont']);

        $transport = Transport::fromDsn("smtp://{$user}:{$cont}@{$config['host']}:{$config['port']}");
        return new Mailer($transport);
    }

    public function __toString()
    {
        return "Envio notificacion por mail";
    }
}
