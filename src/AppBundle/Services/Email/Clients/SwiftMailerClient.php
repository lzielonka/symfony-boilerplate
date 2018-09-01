<?php

namespace AppBundle\Services\Email\Clients;

use AppBundle\Services\Email\DTO\EmailDTO;
use AppBundle\Services\Email\Interfaces\EmailClientInterface;

class SwiftMailerClient implements EmailClientInterface
{
    /** @var \Swift_Mailer */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail(EmailDTO $emailDTO) {
        $message = new \Swift_Message;
        $message
            ->setFrom($emailDTO->sender)
            ->setTo($emailDTO->recipient)
            ->setSubject($emailDTO->subject)
            ->setBody($emailDTO->body)
            ->setContentType($emailDTO->contentType)
            ->setCharset($emailDTO->charset);

        return $this->mailer->send($message);
    }
}