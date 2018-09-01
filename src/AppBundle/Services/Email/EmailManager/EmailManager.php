<?php

namespace AppBundle\Services\Email\EmailManager;

use AppBundle\Services\Email\DTO\EmailDTO;
use AppBundle\Services\Email\Interfaces\EmailClientInterface;

class EmailManager
{
    private const DEFAULT_RECIPIENT = 'fake@example.com';

    /** @var EmailClientInterface */
    private $emailClient;

    public function __construct(EmailClientInterface $emailClient)
    {
        $this->emailClient = $emailClient;
    }

    public function sendProductCreationEmail(string $recipient = null)
    {
        $emailDTO = new EmailDTO;
        $emailDTO->sender = 'sender@app.com';
        $emailDTO->recipient = $recipient ?? self::DEFAULT_RECIPIENT;
        $emailDTO->subject = 'new_product_created_title';
        $emailDTO->body = 'new_product_created_body';

        return $this->sendEmail($emailDTO);
    }

    private function sendEmail(EmailDTO $emailDTO)
    {
        return $this->emailClient->sendEmail($emailDTO);
    }
}